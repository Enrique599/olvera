<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prenda extends Model
{
    protected $table = 'prendas';

    protected $fillable = ['nombre', 'num_piezas'];
}
