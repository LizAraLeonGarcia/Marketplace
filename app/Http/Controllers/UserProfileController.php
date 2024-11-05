<?php

namespace App\Http\Controllers;

use App\Models\Producto; 
use App\Models\Sale;
use App\Models\Image;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function perfilComprador()
    {
        // Obtiene el usuario autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes estar autenticado para ver tu perfil de comprador.');
        }

        $user = auth()->user();        
        // Obtiene las compras del usuario autenticado con Eager Loading
        $compras = $user->compras()->with('productos')->get(); // Cargar relaciones necesarias
        // Obtén la primera orden completada, si existe
        $order = $user->orders()->where('status', 'completed')->first();
    
        $message = $compras->isEmpty() ? "No has realizado ninguna compra todavía." : null;
        // Cargar las reseñas recibidas por el comprador, donde el tipo de reviewable es 'App\Models\User'
        $reviewsReceived = $user->reviews()->where('reviewable_type', 'App\Models\User')->get();
        // Retorna la vista con las compras
        return view('/cuenta/comprador', compact('compras', 'user', 'order', 'reviewsReceived', 'message'));
    }

    public function perfilVendedor()
    {
        // Obtiene el usuario autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes estar autenticado para ver tu perfil de vendedor.');
        }
        
        $user = auth()->user();        
        // Obtiene los productos asociados al vendedor autenticado con Eager Loading
        $productos = $user->productos()->with(['images', 'categoria'])->get(); // Cargar relaciones necesarias
        // Busca un pedido completado relacionado con este vendedor
        $order = $user->orders()->where('status', 'completed')->first();
        // Mensaje en caso de no tener productos
        $message = $productos->isEmpty() ? "No tienes productos en venta." : null;
        // Carga las reseñas donde el tipo es `User`
        $reviewsReceived = $user->reviews()->where('reviewable_type', 'App\Models\User')->get();
        // Retorna la vista con los productos y el usuario
        return view('/cuenta/vendedor', compact('productos', 'user', 'order', 'reviewsReceived', 'message'));
    }
}
