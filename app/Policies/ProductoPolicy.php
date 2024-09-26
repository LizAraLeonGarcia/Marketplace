<?php

namespace App\Policies;

use App\Models\User;

class ProductoPolicy
{
    public function viewAny(User $user)
    {
        return true; // Permitir a todos ver productos
    }

    public function create(User $user)
    {
        return $user->isAdmin(); // Permitir solo a administradores
    }

    public function update(User $user, Producto $producto)
    {
        return $user->id === $producto->user_id; // Solo el creador puede actualizar
    }

    public function delete(User $user, Producto $producto)
    {
        return $user->isAdmin(); // Solo los administradores pueden eliminar
    }
}