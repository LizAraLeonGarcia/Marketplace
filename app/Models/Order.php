<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id', 'seller_id', 'product_id', 'status'
    ];
    // Relación con el comprador
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    // Relación con el vendedor
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    // Relación con el producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // Método para verificar si el pedido está completado
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
    // Método para verificar si existe una reseña del comprador
    public function hasBuyerReview()
    {
        return $this->reviews()->where('type', 'buyer')->exists();
    }
    // Método para verificar si existe una reseña del vendedor
    public function hasSellerReview()
    {
        return $this->reviews()->where('type', 'seller')->exists();
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
