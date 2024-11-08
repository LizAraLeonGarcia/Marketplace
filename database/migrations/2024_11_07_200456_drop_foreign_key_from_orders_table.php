<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Eliminar la restricción de clave foránea
            $table->dropForeign(['producto_id']);
            // Eliminar la columna producto_id
            $table->dropColumn('producto_id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Volver a agregar la columna producto_id
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
        });
    }
};
