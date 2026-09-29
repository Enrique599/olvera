<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venta extends Model
{
    public const ESTADOS_PAGO  = ['PENDIENTE', 'PAGADO', 'PARCIAL', 'CANCELADO'];
    public const METODOS_PAGO  = ['EFECTIVO', 'TRANSFERENCIA', 'TARJETA', 'CHEQUE'];

    /** estado => [etiqueta, color] */
    public const BADGES_PAGO = [
        'PAGADO'    => ['✅ PAGADO', '#22d3a5'],
        'PENDIENTE' => ['⏳ PENDIENTE', '#f7c948'],
        'PARCIAL'   => ['🔶 PARCIAL', '#f97316'],
        'CANCELADO' => ['❌ CANCELADO', '#f75e5e'],
    ];

    protected $table = 'ventas';

    protected $fillable = [
        'fecha',
        'realizacion',
        'total',
        'cliente_id',
        'total_piezas',
        'estado_pago',
        'metodo_pago',
        'notas_pago',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'total' => 'decimal:2',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
