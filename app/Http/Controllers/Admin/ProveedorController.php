<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index(): View
    {
        return $this->vista(null);
    }

    public function edit(Proveedor $proveedor): View
    {
        return $this->vista($proveedor);
    }

    public function store(Request $request): RedirectResponse
    {
        Proveedor::create($this->validar($request));

        return redirect()->route('admin.proveedores.index')->with('ok', 'Proveedor guardado.');
    }

    public function update(Request $request, Proveedor $proveedor): RedirectResponse
    {
        $proveedor->update($this->validar($request));

        return redirect()->route('admin.proveedores.index')->with('ok', 'Proveedor actualizado.');
    }

    public function destroy(Proveedor $proveedor): RedirectResponse
    {
        if ($proveedor->pedidos()->exists()) {
            return back()->with('err', 'No se puede eliminar: el proveedor tiene pedidos registrados.');
        }

        $proveedor->delete();

        return redirect()->route('admin.proveedores.index')->with('ok', 'Proveedor eliminado.');
    }

    private function vista(?Proveedor $registro): View
    {
        return view('htmla.registroprove', [
            'registro'    => $registro,
            'proveedores' => Proveedor::orderBy('id')->get(),
        ]);
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'nombre'           => ['required', 'string', 'max:120'],
            'apellido_paterno' => ['required', 'string', 'max:80'],
            'telefono'         => ['required', 'digits:10'],
            'direccion'        => ['required', 'string', 'max:255'],
        ]);
    }
}
