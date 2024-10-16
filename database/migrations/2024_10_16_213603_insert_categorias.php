<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class InsertCategorias extends Migration
{
    public function up()
    {
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

    public function down()
    {
        DB::table('categorias')->truncate(); // Elimina todos los registros
    }
}
