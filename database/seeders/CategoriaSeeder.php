<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run()
    {    
        $categorias = [
            'Accesorios',
            'Calzado',
            'Cocina',
            'Coleccionables',
            'Escolar',
            'Hogar',
            'Oficina',
            'Ropa',
            'Videojuegos',
        ];

        foreach ($categorias as $nombre) {
            Categoria::firstOrCreate(['nombre' => $nombre], [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}