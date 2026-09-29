<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\PedidoCliente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PedidoClienteController extends Controller
{
    public function index(): View
    {
        // Más urgentes primero y, dentro de cada prioridad, los más antiguos
        $pedidos = PedidoCliente::with('cliente')->get()
            ->sortBy([
                fn (PedidoCliente $a, PedidoCliente $b) => PedidoCliente::RANGO[$b->prioridad_efectiva] <=> PedidoCliente::RANGO[$a->prioridad_efectiva],
                fn (PedidoCliente $a, PedidoCliente $b) => $a->fecha <=> $b->fecha,
            ])
            ->values();

        return view('htmla.pedidosclien', [
            'pedidos'  => $pedidos,
            'clientes' => Cliente::orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'cliente_id'   => ['required', 'exists:clientes,id'],
            'fecha'        => ['required', 'date'],
            'total'        => ['required', 'numeric', 'min:0'],
            'total_piezas' => ['required', 'integer', 'min:1'],
            'prioridad'    => ['required', Rule::in(array_keys(PedidoCliente::RANGO))],
        ]);

        PedidoCliente::create($datos);

        return redirect()->route('admin.pedidos-clientes.index')->with('ok', 'Pedido registrado.');
    }

    public function destroy(PedidoCliente $pedido): RedirectResponse
    {
        $pedido->delete();

        return redirect()->route('admin.pedidos-clientes.index')->with('ok', 'Pedido eliminado.');
    }
}
