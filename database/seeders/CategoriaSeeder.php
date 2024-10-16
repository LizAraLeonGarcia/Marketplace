<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Accesorios', 'Calzado', 'Cocina', 'Coleccionables', 
            'Escolar', 'Hogar', 'Oficina', 'Ropa', 'Videojuegos'
        ];

        foreach ($categorias as $categoria) {
            Categoria::create(['nombre' => $categoria]);
        }
    }
}

