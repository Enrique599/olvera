<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index(): View
    {
        return $this->vista(null);
    }

    public function edit(Cliente $cliente): View
    {
        return $this->vista($cliente);
    }

    public function store(Request $request): RedirectResponse
    {
        Cliente::create($this->validar($request));

        return redirect()->route('admin.clientes.index')->with('ok', 'Cliente registrado.');
    }

    public function update(Request $request, Cliente $cliente): RedirectResponse
    {
        $datos = $this->validar($request, $cliente);

        if (empty($datos['contrasena'])) {
            unset($datos['contrasena']); // vacía = no cambiar
        }

        $cliente->update($datos);

        return redirect()->route('admin.clientes.index')->with('ok', 'Cliente actualizado.');
    }

    public function destroy(Cliente $cliente): RedirectResponse
    {
        if ($cliente->ventas()->exists() || $cliente->pedidos()->exists()) {
            return back()->with('err', 'No se puede eliminar: el cliente tiene ventas o pedidos.');
        }

        $cliente->delete();

        return redirect()->route('admin.clientes.index')->with('ok', 'Cliente eliminado.');
    }

    private function vista(?Cliente $registro): View
    {
        return view('htmla.clientes', [
            'registro' => $registro,
            'clientes' => Cliente::orderByDesc('id')->get(),
        ]);
    }

    private function validar(Request $request, ?Cliente $cliente = null): array
    {
        return $request->validate([
            'nombre'           => ['required', 'string', 'max:80'],
            'apellido_paterno' => ['required', 'string', 'max:80'],
            'telefono'         => ['required', 'digits:10', Rule::unique('clientes', 'telefono')->ignore($cliente)],
            'contrasena'       => [$cliente ? 'nullable' : 'required', 'string', 'min:6'],
        ]);
    }
}
