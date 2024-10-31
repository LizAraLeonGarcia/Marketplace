<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['producto_id', 'path'];
    // ------------------------------------------------------------------------------------------------------------------ Relacion con productos
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    // Accesor para obtener la URL completa de la imagen
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
