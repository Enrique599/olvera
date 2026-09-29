<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoProveedor extends Model
{
    public const ESTADOS = ['Pendiente', 'Enviado', 'Recibido', 'Cancelado'];

    /** estado => color */
    public const COLORES = [
        'Pendiente' => '#f7c948',
        'Enviado'   => '#4f8ef7',
        'Recibido'  => '#22d3a5',
        'Cancelado' => '#f75e5e',
    ];

    protected $table = 'pedidos_proveedores';

    protected $fillable = ['proveedor_id', 'fecha', 'total', 'total_piezas', 'estado'];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'total' => 'decimal:2',
        ];
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }
}
