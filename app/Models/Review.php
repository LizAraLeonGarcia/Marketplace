<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'review', 'rating', 'user_id', 'reviewable_id', 'reviewable_type'
    ];
    // ------------------------------------------------------------------------------------------------------------------- Relación polimórfica
    public function reviewable()
    {
        return $this->morphTo();
    }
    // ------------------------------------------------------------------------------------------ Relación con el usuario que realiza la reseña
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
