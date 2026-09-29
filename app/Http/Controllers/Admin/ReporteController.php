<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class ReporteController extends Controller
{
    public function index(): View
    {
        return view('htmla.reportepdf');
    }

    public function clientes(): Response
    {
        $pdf = Pdf::loadView('reportes.clientes_pdf', [
            'clientes' => Cliente::orderBy('id')->get(),
            'generado' => now(),
        ]);

        return $pdf->download('reporte_clientes_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
