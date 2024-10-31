<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarritosTable extends Migration
{
    public function up()
    {
        Schema::create('carritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('cantidad')->default(1);
            $table->timestamps();
            // Agregar índice para mejorar el rendimiento
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carritos');
    }
}
