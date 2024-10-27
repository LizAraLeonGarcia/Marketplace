<?php

namespace App\Http\Controllers;

use App\Models\Producto; 
use App\Models\Sale;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function perfilComprador()
    {
        // Obtiene las compras del usuario autenticado
        $compras = auth()->user()->compras;
        // Obtiene el usuario autenticado
        $user = auth()->user();
        // Retorna la vista con las compras
        return view('comprador', compact('compras', 'user'));
    }

    public function perfilVendedor()
    {
        // Obtiene los productos asociados al vendedor autenticado
        $productos = Producto::where('vendedor_id', auth()->id())->get();
        // Obtiene el usuario autenticado
        $user = auth()->user();
        // Retorna la vista con los productos y el usuario
        return view('vendedor', compact('productos', 'user'));
    }
}
