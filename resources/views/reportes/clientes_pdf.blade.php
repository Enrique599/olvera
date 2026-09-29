<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de clientes</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        h1 { font-size: 18px; margin: 0 0 4px; color: #1a3a6e; }
        .fecha { color: #666; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1a3a6e; color: #fff; text-align: left; padding: 6px; }
        td { padding: 5px 6px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) td { background: #f5f7fb; }
    </style>
</head>
<body>
    <h1>DAV Tienda — Reporte de clientes</h1>
    <div class="fecha">Generado el {{ $generado->format('d/m/Y H:i:s') }} · {{ $clientes->count() }} clientes</div>

    <table>
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Teléfono</th><th>Dirección</th><th>C.P.</th></tr>
        </thead>
        <tbody>
            @forelse ($clientes as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->nombre_completo }}</td>
                    <td>{{ $c->telefono }}</td>
                    <td>{{ $c->direccion ?? '—' }}</td>
                    <td>{{ $c->codigo_postal ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Sin clientes registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
