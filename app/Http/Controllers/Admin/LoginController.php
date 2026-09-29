<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\View\View;

class LoginController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        if ($request->session()->has('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return view('htmla.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'telefono'   => ['required', 'string'],
            'contrasena' => ['required', 'string'],
        ]);

        // Acceso por defecto (config/admin.php)
        if (hash_equals((string) config('admin.usuario'), $datos['telefono'])
            && hash_equals((string) config('admin.contrasena'), $datos['contrasena'])) {
            return $this->iniciar($request, null, 'Administrador', 'admin');
        }

        // Empleados registrados en la BD
        $empleado = Empleado::where('telefono', $datos['telefono'])->first();

        if ($empleado && Hash::check($datos['contrasena'], $empleado->contrasena)) {
            return $this->iniciar($request, $empleado->id, $empleado->nombre_completo, $empleado->rol);
        }

        return back()
            ->withErrors(['telefono' => 'Usuario o contraseña incorrectos.'])
            ->onlyInput('telefono');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('admin');
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    private function iniciar(Request $request, ?int $id, string $nombre, string $rol): RedirectResponse
    {
        $request->session()->regenerate();
        $request->session()->put('admin', compact('id', 'nombre', 'rol'));

        return redirect()->route('admin.dashboard');
    }
}
