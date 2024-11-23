<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con la tabla users
            $table->string('stripe_payment_method_id')->unique(); // ID único del método de pago de Stripe
            $table->string('brand'); // Marca del método de pago (Visa, Mastercard, etc.)
            $table->string('last4'); // Últimos 4 dígitos del método de pago
            $table->string('exp_month'); // Mes de expiración
            $table->string('exp_year'); // Año de expiración
            $table->boolean('is_default')->default(false); // Método de pago por defecto
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
