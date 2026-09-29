<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Respaldo/restauración de los DATOS del sistema en un .sql (una sentencia por línea).
 * La estructura de tablas la maneja `php artisan migrate`.
 * Funciona igual con SQLite y MySQL.
 */
class RespaldoController extends Controller
{
    /** En orden de dependencia: primero los padres, después los hijos. */
    private const TABLAS = [
        'categorias',
        'clientes',
        'empleados',
        'proveedores',
        'prendas',
        'productos',
        'ventas',
        'pedidos_clientes',
        'pedidos_proveedores',
    ];

    public function respaldar(): View
    {
        return view('htmla.respaldarbd');
    }

    public function descargar(): StreamedResponse
    {
        $nombre = 'respaldo_' . now()->format('Y-m-d_H-i-s') . '.sql';

        return response()->streamDownload(function () {
            $pdo = DB::connection()->getPdo();

            echo '-- Respaldo DAV Tienda ' . now()->toDateTimeString() . "\n";

            // Primero se vacían las tablas hijas y al final las padres
            foreach (array_reverse(self::TABLAS) as $tabla) {
                echo "DELETE FROM `{$tabla}`;\n";
            }

            foreach (self::TABLAS as $tabla) {
                foreach (DB::table($tabla)->orderBy('id')->cursor() as $fila) {
                    $fila = (array) $fila;
                    $columnas = '`' . implode('`, `', array_keys($fila)) . '`';
                    $valores = implode(', ', array_map(function ($v) use ($pdo) {
                        if ($v === null) {
                            return 'NULL';
                        }
                        if (is_int($v) || is_float($v)) {
                            return (string) $v;
                        }

                        // una sentencia por línea: los saltos de línea se vuelven espacios
                        return $pdo->quote(str_replace(["\r", "\n"], ' ', (string) $v));
                    }, $fila));

                    echo "INSERT INTO `{$tabla}` ({$columnas}) VALUES ({$valores});\n";
                }
            }
        }, $nombre, ['Content-Type' => 'application/sql']);
    }

    public function restaurar(): View
    {
        return view('htmla.restaurarbd');
    }

    public function subir(Request $request): RedirectResponse
    {
        $request->validate([
            'archivo' => ['required', 'file', 'max:20480'],
        ]);

        $archivo = $request->file('archivo');

        if (strtolower($archivo->getClientOriginalExtension()) !== 'sql') {
            return back()->with('err', 'El archivo debe ser un .sql');
        }

        $tablas = implode('|', self::TABLAS);
        $patron = '/^(DELETE FROM|INSERT INTO) `(' . $tablas . ')`/';
        $lineas = file($archivo->getRealPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];

        try {
            DB::transaction(function () use ($lineas, $patron) {
                foreach ($lineas as $n => $linea) {
                    $linea = trim($linea);

                    if ($linea === '' || str_starts_with($linea, '--')) {
                        continue;
                    }

                    if (! preg_match($patron, $linea) || ! $this->unaSolaSentencia($linea)) {
                        throw new \RuntimeException('Línea ' . ($n + 1) . ' no reconocida; no es un respaldo de este sistema.');
                    }

                    DB::unprepared($linea);
                }
            });
        } catch (\Throwable $e) {
            return back()->with('err', 'No se pudo restaurar (no se aplicó ningún cambio): ' . $e->getMessage());
        }

        return redirect()->route('admin.restaurar')->with('ok', 'Base de datos restaurada correctamente.');
    }

    /** Evita encadenar otras sentencias en la misma línea (el ';' solo puede ir al final). */
    private function unaSolaSentencia(string $linea): bool
    {
        $sinTextos = preg_replace("/'(?:[^'\\\\]|\\\\.|'')*'/", "''", $linea);

        return $sinTextos !== null
            && str_ends_with($sinTextos, ';')
            && substr_count($sinTextos, ';') === 1;
    }
}
