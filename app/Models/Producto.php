<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id', 
        'user_id',
    ];
    // ------------------------------------------------------------------------------------------------------------------ Relacion con categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    // ------------------------------------------------------------------------------------------------------------------- Relación con imágenes
    public function images()
    {
        return $this->hasMany(Image::class, 'producto_id');
    }
    // ----------------------------------------------------------------------------------------------------------------------- Relacion con user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // -------------------------------------------------------------------------------------------------------------------- Relacion con carrito
    public function carritos()
    {
        return $this->belongsToMany(User::class, 'carritos')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
    //    
    public function ventas()
    {
        return $this->hasMany(Sale::class, 'producto_id');
    }
    // -------------------------------------------------------------------------------------------------------------------- Relación con reseñas
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
