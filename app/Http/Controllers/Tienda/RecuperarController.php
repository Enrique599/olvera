<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RecuperarController extends Controller
{
    /** Paso 1: pedir el teléfono */
    public function paso1(): View
    {
        return view('htmlv.recuperarcon');
    }

    public function buscar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'telefono' => ['required', 'digits:10'],
        ]);

        $cliente = Cliente::where('telefono', $datos['telefono'])->first();

        if (! $cliente) {
            return back()
                ->withErrors(['telefono' => 'No encontramos una cuenta con ese teléfono.'])
                ->onlyInput('telefono');
        }

        $request->session()->put('recuperar_cliente_id', $cliente->id);

        return redirect()->route('tienda.recuperar.paso2');
    }

    /** Paso 2: capturar la nueva contraseña */
    public function paso2(Request $request): View|RedirectResponse
    {
        $cliente = Cliente::find($request->session()->get('recuperar_cliente_id'));

        if (! $cliente) {
            return redirect()->route('tienda.recuperar');
        }

        return view('htmlv.recuperarco2', ['cliente' => $cliente]);
    }

    public function guardar(Request $request): RedirectResponse
    {
        $cliente = Cliente::find($request->session()->get('recuperar_cliente_id'));

        if (! $cliente) {
            return redirect()->route('tienda.recuperar');
        }

        $datos = $request->validate([
            'nueva'     => ['required', 'string', 'min:6', 'same:confirmar'],
            'confirmar' => ['required', 'string'],
        ]);

        $cliente->update(['contrasena' => $datos['nueva']]);
        $request->session()->forget('recuperar_cliente_id');

        return redirect()->route('tienda.recuperar.exito');
    }

    /** Paso 3: listo */
    public function exito(): View
    {
        return view('htmlv.recuperarcon3');
    }
}
