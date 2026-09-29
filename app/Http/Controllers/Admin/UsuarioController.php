<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index(): View
    {
        return $this->vista(null);
    }

    public function edit(Empleado $usuario): View
    {
        return $this->vista($usuario);
    }

    public function store(Request $request): RedirectResponse
    {
        Empleado::create($this->validar($request));

        return redirect()->route('admin.usuarios.index')->with('ok', 'Empleado registrado.');
    }

    public function update(Request $request, Empleado $usuario): RedirectResponse
    {
        $datos = $this->validar($request, $usuario);

        if (empty($datos['contrasena'])) {
            unset($datos['contrasena']);
        }

        $usuario->update($datos);

        return redirect()->route('admin.usuarios.index')->with('ok', 'Empleado actualizado.');
    }

    public function destroy(Request $request, Empleado $usuario): RedirectResponse
    {
        if ($request->session()->get('admin.id') === $usuario->id) {
            return back()->with('err', 'No puedes eliminar tu propio usuario.');
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('ok', 'Empleado eliminado.');
    }

    private function vista(?Empleado $registro): View
    {
        return view('htmla.usuarios', [
            'registro'  => $registro,
            'empleados' => Empleado::orderBy('id')->get(),
            'roles'     => Empleado::ROLES,
        ]);
    }

    private function validar(Request $request, ?Empleado $empleado = null): array
    {
        return $request->validate([
            'nombre'           => ['required', 'string', 'max:80'],
            'apellido_paterno' => ['required', 'string', 'max:80'],
            'telefono'         => ['required', 'digits:10', Rule::unique('empleados', 'telefono')->ignore($empleado)],
            'direccion'        => ['required', 'string', 'max:255'],
            'contrasena'       => [$empleado ? 'nullable' : 'required', 'string', 'min:6'],
            'rol'              => ['required', Rule::in(array_keys(Empleado::ROLES))],
        ]);
    }
}
