<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prenda;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PrendaController extends Controller
{
    public function index(): View
    {
        return $this->vista(null);
    }

    public function edit(Prenda $prenda): View
    {
        return $this->vista($prenda);
    }

    public function store(Request $request): RedirectResponse
    {
        Prenda::create($this->validar($request));

        return redirect()->route('admin.prendas.index')->with('ok', 'Prenda registrada.');
    }

    public function update(Request $request, Prenda $prenda): RedirectResponse
    {
        $prenda->update($this->validar($request));

        return redirect()->route('admin.prendas.index')->with('ok', 'Prenda actualizada.');
    }

    public function destroy(Prenda $prenda): RedirectResponse
    {
        $prenda->delete();

        return redirect()->route('admin.prendas.index')->with('ok', 'Prenda eliminada.');
    }

    private function vista(?Prenda $registro): View
    {
        return view('htmla.prendas', [
            'registro' => $registro,
            'prendas'  => Prenda::orderBy('id')->get(),
        ]);
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'nombre'     => ['required', 'string', 'max:100'],
            'num_piezas' => ['required', 'integer', 'min:0'],
        ]);
    }
}
