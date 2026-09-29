<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    public const ROLES = [
        'admin'    => 'Administrador',
        'vendedor' => 'Vendedor',
        'almacen'  => 'Almacén',
        'contador' => 'Contador',
    ];

    protected $table = 'empleados';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'telefono',
        'direccion',
        'contrasena',
        'rol',
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
}
