<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('htmlv.login');
    }

    public function autenticar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'telefono'   => ['required', 'string'],
            'contrasena' => ['required', 'string'],
        ]);

        $cliente = Cliente::where('telefono', $datos['telefono'])->first();

        if (! $cliente || ! Hash::check($datos['contrasena'], $cliente->contrasena)) {
            return back()
                ->withErrors(['telefono' => 'Teléfono o contraseña incorrectos.'])
                ->onlyInput('telefono');
        }

        $request->session()->regenerate();
        $request->session()->put('cliente', [
            'id'     => $cliente->id,
            'nombre' => $cliente->nombre_completo,
        ]);

        return redirect()->route('tienda.tienda');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('cliente');
        $request->session()->regenerateToken();

        return redirect()->route('tienda.inicio');
    }

    public function registro(): View
    {
        return view('htmlv.crearcu');
    }

    public function registrar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre'     => ['required', 'string', 'max:80'],
            'paterno'    => ['required', 'string', 'max:80'],
            'telefono'   => ['required', 'digits:10', 'unique:clientes,telefono'],
            'contrasena' => ['required', 'string', 'min:6', 'same:confirmar'],
            'confirmar'  => ['required', 'string'],
            'direccion'  => ['required', 'string', 'max:255'],
            'cp'         => ['required', 'digits:5'],
        ]);

        Cliente::create([
            'nombre'           => $datos['nombre'],
            'apellido_paterno' => $datos['paterno'],
            'telefono'         => $datos['telefono'],
            'contrasena'       => $datos['contrasena'],
            'direccion'        => $datos['direccion'],
            'codigo_postal'    => $datos['cp'],
        ]);

        return redirect()->route('tienda.registro.exito');
    }

    public function registroExito(): View
    {
        return view('htmlv.crearcuex');
    }
}
