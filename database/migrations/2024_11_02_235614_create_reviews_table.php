<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->text('review');                 // Texto de la reseña
            $table->unsignedTinyInteger('rating');  // Puntuación (1-5, por ejemplo)
            $table->unsignedBigInteger('user_id');  // Usuario que realiza la reseña
            $table->morphs('reviewable');           // Campos polimórficos: reviewable_id y reviewable_type
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
