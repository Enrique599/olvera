<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index(): View
    {
        return $this->vista(null);
    }

    public function edit(Venta $venta): View
    {
        return $this->vista($venta);
    }

    public function store(Request $request): RedirectResponse
    {
        Venta::create($this->validar($request));

        return redirect()->route('admin.ventas.index')->with('ok', 'Venta registrada.');
    }

    public function update(Request $request, Venta $venta): RedirectResponse
    {
        $venta->update($this->validar($request));

        return redirect()->route('admin.ventas.index')->with('ok', 'Venta actualizada.');
    }

    public function destroy(Venta $venta): RedirectResponse
    {
        $venta->delete();

        return redirect()->route('admin.ventas.index')->with('ok', 'Venta eliminada.');
    }

    private function vista(?Venta $registro): View
    {
        return view('htmla.ventas', [
            'registro' => $registro,
            'ventas'   => Venta::with('cliente')->orderByDesc('id')->get(),
            'clientes' => Cliente::orderBy('nombre')->get(),
        ]);
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'fecha'        => ['required', 'date'],
            'realizacion'  => ['required', 'string', 'max:255'],
            'total'        => ['required', 'numeric', 'min:0'],
            'cliente_id'   => ['required', 'exists:clientes,id'],
            'total_piezas' => ['required', 'integer', 'min:1'],
        ]);
    }
}
