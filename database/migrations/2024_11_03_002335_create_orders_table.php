<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade'); // comprador
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade'); // vendedor
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade'); // producto
            $table->enum('status', ['pending', 'completed', 'shipped'])->default('pending'); // estado del pedido
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
