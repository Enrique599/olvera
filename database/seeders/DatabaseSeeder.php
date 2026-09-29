<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Playeras'   => 'ves1.jpg',
            'Pantalones' => 'ves2.jpg',
            'Chamarras'  => 'ves3.jpg',
            'Accesorios' => 'images.jpg', // esta imagen no venía en maquetado/
            'General'    => null,
        ];

        foreach ($categorias as $nombre => $imagen) {
            Categoria::firstOrCreate(['nombre' => $nombre], ['imagen' => $imagen]);
        }
    }
}
