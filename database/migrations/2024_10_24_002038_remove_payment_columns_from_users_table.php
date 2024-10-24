<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['numero_tarjeta', 'fecha_expiracion', 'cvv', 'metodo_pago']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('numero_tarjeta')->nullable();
            $table->string('fecha_expiracion')->nullable();
            $table->string('cvv')->nullable();
            $table->string('metodo_pago')->nullable();
        });
    }
};
