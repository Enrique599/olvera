<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ValidacionPagoController extends Controller
{
    public function index(): View
    {
        return view('htmla.validacionpa', [
            'ventas' => Venta::with('cliente')->orderByDesc('id')->get(),
            'stats'  => [
                'pagados'    => Venta::where('estado_pago', 'PAGADO')->count(),
                'pendientes' => Venta::where('estado_pago', 'PENDIENTE')->count(),
                'parciales'  => Venta::where('estado_pago', 'PARCIAL')->count(),
                'monto'      => (float) Venta::where('estado_pago', 'PENDIENTE')->sum('total'),
            ],
        ]);
    }

    public function update(Request $request, Venta $venta): RedirectResponse
    {
        $datos = $request->validate([
            'estado_pago' => ['required', Rule::in(Venta::ESTADOS_PAGO)],
            'metodo_pago' => ['required', Rule::in(Venta::METODOS_PAGO)],
            'notas_pago'  => ['nullable', 'string', 'max:255'],
        ]);

        $venta->update($datos);

        return redirect()->route('admin.pagos.index')->with('ok', "Pago de la venta #{$venta->id} actualizado.");
    }
}
