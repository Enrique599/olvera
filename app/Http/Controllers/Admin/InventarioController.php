<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(): View
    {
        $productos = Producto::with('categoria')->orderBy('stock')->orderBy('nombre')->get();

        return view('htmla.inventario', [
            'productos' => $productos,
            'stats'     => [
                'productos' => $productos->count(),
                'unidades'  => (int) $productos->sum('stock'),
                'valor'     => (float) $productos->sum(fn (Producto $p) => $p->valor_stock),
                'bajo'      => $productos->where('stock', '<', Producto::STOCK_BAJO)->count(),
            ],
        ]);
    }

    public function update(Request $request, Producto $producto): RedirectResponse
    {
        $datos = $request->validate([
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $producto->update($datos);

        return redirect()->route('admin.inventario.index')->with('ok', "Stock de {$producto->nombre} actualizado.");
    }
}
