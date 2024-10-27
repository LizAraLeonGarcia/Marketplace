<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'vendedor_id',
        'user_id',
        'precio_venta',
        'cantidad',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relación con el modelo User
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
