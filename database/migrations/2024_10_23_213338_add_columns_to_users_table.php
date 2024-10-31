<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('apodo')->nullable();
            $table->string('pais')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('foto')->nullable();
            $table->string('sexo')->nullable();
            $table->date('fecha_nacimiento')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nombre', 'apellido', 'apodo', 'pais', 'descripcion', 'foto',
                'sexo', 'fecha_nacimiento'
            ]);
        });
    }
}
