<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRolesToUsersTable extends Migration
{
    /* Run the migrations */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_vendedor')->default(false)->after('remember_token');
            $table->boolean('is_comprador')->default(true)->after('is_vendedor');
        });
    }

    /* Reverse the migrations */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_vendedor');
            $table->dropColumn('is_comprador');
        });
    }
}
