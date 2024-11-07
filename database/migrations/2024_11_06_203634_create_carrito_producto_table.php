<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarritoProductoTable extends Migration
{
    public function up()
    {
        Schema::create('carrito_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('cantidad')->default(1);
            $table->timestamps();

            // Indices para mejorar el rendimiento de la consulta
            $table->unique(['user_id', 'producto_id']); // Asegura que un producto solo esté en el carrito de un usuario una vez
        });
    }

    public function down()
    {
        Schema::dropIfExists('carrito_producto');
    }
}
