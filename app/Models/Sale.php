<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'producto_id',
        'user_id',
        'precio_venta',
        'cantidad',
    ];
    // ----------------------------------------------------------------------------------------------------------------------- Relacion con user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
    // ------------------------------------------------------------------------------------------------------------------ Relacion con productos
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
