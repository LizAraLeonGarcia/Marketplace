<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run()    {
        DB::table('categorias')->insert([
            ['nombre' => 'Accesorios'],
            ['nombre' => 'Calzado'],
            ['nombre' => 'Cocina'],
            ['nombre' => 'Coleccionables'],
            ['nombre' => 'Escolar'],
            ['nombre' => 'Hogar'],
            ['nombre' => 'Oficina'],
            ['nombre' => 'Ropa'],
            ['nombre' => 'Videojuegos'],
        ]);
    }
}

