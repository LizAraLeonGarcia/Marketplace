<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['producto_id', 'path'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
