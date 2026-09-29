<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = ['nombre', 'apellido_paterno', 'telefono', 'direccion'];

    public function pedidos(): HasMany
    {
        return $this->hasMany(PedidoProveedor::class);
    }
}
