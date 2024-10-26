<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;

class ProductPolicy
{
    public function update(User $user, Producto $producto)
    {
        return $user->id === $producto->user_id; // Solo el creador puede editar
    }

    public function delete(User $user, Producto $producto)
    {
        return $user->id === $producto->user_id; // Solo el creador puede eliminar
    }
}
