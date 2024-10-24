<?php

namespace App\Http\Controllers;

use App\Models\Producto; 
use App\Models\Sale;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function perfilComprador()
    {
      //  $compras = auth()->user()->compras; // 
      //  return view('perfil.comprador', compact('compras'));
    }

    public function perfilVendedor()
    {
        // Obtiene los productos asociados al vendedor autenticado
        $productos = Producto::where('vendedor_id', auth()->id())->get();
        // Verifica que la variable $productos esté correctamente definida
        return view('vendedor', compact('productos'));
    }
}
