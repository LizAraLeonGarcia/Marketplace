<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $fillable = ['user_id', 'producto_id', 'cantidad'];
    // -------------------------------------------------------------------------------------------------Relación inversa con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    // ---------------------------------------------------------------------------------------------------- Relación inversa con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
