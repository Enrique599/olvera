<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PedidoProveedor;
use App\Models\Proveedor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PedidoProveedorController extends Controller
{
    public function index(): View
    {
        return view('htmla.pedidosproove', [
            'pedidos'     => PedidoProveedor::with('proveedor')->orderByDesc('id')->get(),
            'proveedores' => Proveedor::orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'proveedor_id' => ['required', 'exists:proveedores,id'],
            'fecha'        => ['required', 'date'],
            'total'        => ['required', 'numeric', 'min:0'],
            'total_piezas' => ['required', 'integer', 'min:1'],
            'estado'       => ['required', Rule::in(PedidoProveedor::ESTADOS)],
        ]);

        PedidoProveedor::create($datos);

        return redirect()->route('admin.pedidos-proveedores.index')->with('ok', 'Pedido guardado.');
    }

    public function destroy(PedidoProveedor $pedido): RedirectResponse
    {
        $pedido->delete();

        return redirect()->route('admin.pedidos-proveedores.index')->with('ok', 'Pedido eliminado.');
    }
}
