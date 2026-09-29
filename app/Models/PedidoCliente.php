<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoCliente extends Model
{
    public const RANGO = ['NORMAL' => 0, 'ALTA' => 1, 'URGENTE' => 2];

    /** prioridad => [etiqueta, color] */
    public const BADGES = [
        'URGENTE' => ['🚨 URGENTE', '#ef4444'],
        'ALTA'    => ['⚠️ ALTA', '#f97316'],
        'NORMAL'  => ['✅ NORMAL', '#22c55e'],
    ];

    protected $table = 'pedidos_clientes';

    protected $fillable = ['cliente_id', 'fecha', 'total', 'total_piezas', 'prioridad'];

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

    public function getDiasEsperaAttribute(): int
    {
        $dias = (int) $this->fecha->copy()->startOfDay()->diffInDays(now()->startOfDay(), false);

        return max(0, $dias);
    }

    /** La prioridad automática por días de espera nunca baja la que se eligió a mano. */
    public function getPrioridadEfectivaAttribute(): string
    {
        $dias = $this->dias_espera;
        $auto = $dias >= 7 ? 'URGENTE' : ($dias >= 3 ? 'ALTA' : 'NORMAL');
        $manual = $this->prioridad ?: 'NORMAL';

        return self::RANGO[$auto] >= self::RANGO[$manual] ? $auto : $manual;
    }
}
