<?php

namespace App\Http\Controllers;

use App\Models\Producto; 
use App\Models\Sale;
use App\Models\Order; 
use App\Models\OrderItem;
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
        // Obtener el usuario autenticado
        $user = auth()->user();        
        // Obtiene las compras del usuario autenticado con Eager Loading. Y filtra de las órdenes completas y las pendientes por separado
        $completedOrders = $user->orders()->where('status', 'completed')->with('items.producto')->get();
        $inProcessOrders = $user->orders()->where('status', 'pending')->with('items.producto')->get();
        // Mensaje si no hay compras
        $message = ($completedOrders->isEmpty() && $inProcessOrders->isEmpty()) ? "No has realizado ninguna compra todavía." : null;
        // Cargar las reseñas recibidas por el comprador
        $reviewsReceived = $user->reviewsReceived;
        // Retorna la vista con las compras
        return view('/cuenta/comprador', compact('user', 'completedOrders', 'inProcessOrders', 'reviewsReceived', 'message'));
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
