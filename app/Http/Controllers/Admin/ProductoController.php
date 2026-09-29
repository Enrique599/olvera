<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(): View
    {
        return view('htmla.productos', [
            'productos'  => Producto::with('categoria')->orderBy('id')->get(),
            'categorias' => Categoria::orderBy('nombre')->get(),
            'stats'      => [
                'productos' => Producto::count(),
                'unidades'  => (int) Producto::sum('stock'),
                'bajo'      => Producto::where('stock', '<', Producto::STOCK_BAJO)->count(),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre'           => ['required', 'string', 'max:120'],
            'stock'            => ['required', 'integer', 'min:0'],
            'categoria_id'     => ['required', 'exists:categorias,id'],
            'precio_proveedor' => ['required', 'numeric', 'min:0'],
            'precio_venta'     => ['required', 'numeric', 'min:0'],
        ]);

        Producto::create($datos);

        return redirect()->route('admin.productos.index')->with('ok', 'Producto guardado.');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        $producto->delete();

        return redirect()->route('admin.productos.index')->with('ok', 'Producto eliminado.');
    }
}
