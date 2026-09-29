<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    public const STOCK_BAJO = 10;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'categoria_id',
        'stock',
        'precio_proveedor',
        'precio_venta',
    ];

    protected function casts(): array
    {
        return [
            'stock'            => 'integer',
            'precio_proveedor' => 'decimal:2',
            'precio_venta'     => 'decimal:2',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function getMargenAttribute(): float
    {
        return (float) $this->precio_venta - (float) $this->precio_proveedor;
    }

    public function getMargenPorcentajeAttribute(): float
    {
        $costo = (float) $this->precio_proveedor;

        return $costo > 0 ? round($this->margen / $costo * 100, 1) : 0;
    }

    public function getValorStockAttribute(): float
    {
        return $this->stock * (float) $this->precio_venta;
    }

    /** Devuelve [etiqueta, color hex] según el stock. */
    public function getNivelStockAttribute(): array
    {
        if ($this->stock === 0) {
            return ['🔴 Agotado', '#ef4444'];
        }

        if ($this->stock < self::STOCK_BAJO) {
            return ['🟠 Bajo', '#f97316'];
        }

        return ['🟢 Bueno', '#22c55e'];
    }
}
