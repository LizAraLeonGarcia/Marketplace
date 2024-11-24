<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'seller_id', 'cantidad', 'precio'];
    // ----------------------------------------------------------------------------------------------------------------- Relacion con producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'product_id');
    }
}
