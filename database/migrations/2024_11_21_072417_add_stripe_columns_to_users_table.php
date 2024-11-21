<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStripeColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('stripe_id')->nullable()->after('id');
            $table->string('pm_type')->nullable()->after('stripe_id'); // Tipo de método de pago (opcional)
            $table->string('pm_last_four')->nullable()->after('pm_type'); // Últimos 4 dígitos de la tarjeta (opcional)
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['stripe_id', 'pm_type', 'pm_last_four']);
        });
    }
}

