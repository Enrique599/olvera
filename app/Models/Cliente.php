<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'telefono',
        'contrasena',
        'direccion',
        'codigo_postal',
    ];

    protected $hidden = ['contrasena'];

    protected function casts(): array
    {
        return ['contrasena' => 'hashed'];
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim($this->nombre . ' ' . $this->apellido_paterno);
    }

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class);
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(PedidoCliente::class);
    }
}
