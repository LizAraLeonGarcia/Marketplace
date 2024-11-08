<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['buyer_id','status'];
    // ...................................................................................... Relación con order - items -
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    // ........................................................................................ Relación con el comprador
    public function user()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    // ......................................................................................... Relación con el vendedor
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    // Método para verificar si el pedido está completado ...............................................................
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
    // Método para verificar si existe una reseña del comprador ...........................................................
    public function hasBuyerReview()
    {
        return $this->reviews()->where('type', 'buyer')->exists();
    }
    // Método para verificar si existe una reseña del vendedor ...........................................................
    public function hasSellerReview()
    {
        return $this->reviews()->where('type', 'seller')->exists();
    }
    // reseñas .........................................................................................................
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
