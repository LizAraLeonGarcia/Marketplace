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
        $message = $compras->isEmpty() ? "No has realizado ninguna compra todavía." : null;
        // Retorna la vista con las compras
        return view('comprador', compact('compras', 'user', 'message'));
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
        $message = $productos->isEmpty() ? "No tienes productos en venta." : null;
        // Retorna la vista con los productos y el usuario
        return view('vendedor', compact('productos', 'user', 'message'));
    }
}
