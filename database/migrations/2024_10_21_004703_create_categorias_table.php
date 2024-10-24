<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Asegúrate de importar la clase DB

class CreateCategoriasTable extends Migration
{
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        // Insertar categorías predeterminadas
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
        Schema::dropIfExists('categorias');
    }
}
