<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Contracts\View\View;

class InicioController extends Controller
{
    public function inicio(): View
    {
        return view('htmlv.inicio');
    }

    public function tienda(): View
    {
        return view('htmlv.tienda');
    }

    public function categorias(): View
    {
        return view('htmlv.categorias', [
            'categorias' => Categoria::withCount('productos')->orderBy('id')->get(),
        ]);
    }
}
