<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCategoriaColumnInProductosTable extends Migration
{
    /* Run the migrations */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Eliminar la clave foránea si existe
            if (Schema::hasColumn('productos', 'categoria_id')) {
                $table->dropForeign(['categoria_id']); // Elimina la clave foránea existente
            }
            
            // Eliminar la columna 'categoria' si existe
            if (Schema::hasColumn('productos', 'categoria')) {
                $table->dropColumn('categoria');
            }

            // Agregar la columna 'categoria_id' si no existe
            if (!Schema::hasColumn('productos', 'categoria_id')) {
                $table->unsignedBigInteger('categoria_id')->after('stock');
            }

            // Agregar la clave foránea
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

            // Vuelve a agregar la columna 'categoria' si es necesario
            $table->string('categoria')->nullable(); // Vuelve a agregar la columna 'categoria'
        });
    }
}
