<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSellerIdForeignKeyFromOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Elimina la clave foránea
            $table->dropForeign(['seller_id']);
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Restaura la clave foránea si es necesario
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
