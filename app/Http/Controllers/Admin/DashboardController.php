<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Prenda;
use App\Models\Venta;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    private const MESES = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

    public function index(): View
    {
        $stats = [
            'clientes' => Cliente::count(),
            'ventas'   => Venta::count(),
            'prendas'  => Prenda::count(),
            'monto'    => (float) Venta::sum('total'),
        ];

        // Ventas de los últimos 6 meses (incluido el actual)
        $inicio = now()->startOfMonth()->subMonths(5);
        $porMes = Venta::where('fecha', '>=', $inicio->toDateString())
            ->get()
            ->groupBy(fn (Venta $v) => $v->fecha->format('Y-m'));

        $etiquetas = [];
        $totales = [];
        for ($i = 0; $i < 6; $i++) {
            $mes = $inicio->copy()->addMonths($i);
            $etiquetas[] = self::MESES[$mes->month - 1] . ' ' . $mes->year;
            $totales[] = (float) ($porMes->get($mes->format('Y-m'))?->sum('total') ?? 0);
        }

        return view('htmla.dashboard', [
            'stats'           => $stats,
            'etiquetas'       => $etiquetas,
            'totales'         => $totales,
            'ultimosClientes' => Cliente::latest('id')->take(5)->get(),
            'ultimasVentas'   => Venta::with('cliente')->latest('id')->take(5)->get(),
        ]);
    }
}
