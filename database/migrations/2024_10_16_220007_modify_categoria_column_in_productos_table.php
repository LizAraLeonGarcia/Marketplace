<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* Run the migrations */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table)
        {
            $table->dropColumn('categoria'); // Elimina la columna 'categoria'
            $table->unsignedBigInteger('categoria_id')->after('stock'); // Agrega la columna 'categoria_id'

            // Definir la clave foránea
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    /* Reverse the migrations */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table)
        {
            // Revertir los cambios
            $table->dropForeign(['categoria_id']); // Elimina la clave foránea
            $table->dropColumn('categoria_id'); // Elimina la columna 'categoria_id'
            $table->string('categoria')->nullable(); // Vuelve a agregar la columna 'categoria'
        });
    }
};

