<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = auth()->user()->carrito; // Obtiene los productos en el carrito del usuario autenticado

        return view('carrito.index', compact('carrito')); // Pasa la variable $carrito a la vista
    }

    public function agregar(Request $request, $producto_id)
    {
        $cantidad = $request->input('cantidad', 1);
        // Asegúrate de que el producto existe
        $producto = Producto::findOrFail($producto_id);
        // Agrega el producto al carrito con la cantidad especificada
        auth()->user()->carrito()->syncWithoutDetaching([
            $producto->id => ['cantidad' => $cantidad]
        ]);

        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito');
    }

    public function eliminar(Producto $producto_id)
    {
        auth()->user()->carrito()->detach($producto->id);
        return redirect()->route('carrito.index')->with('success', 'Producto eliminado del carrito');
    }

    public function mostrar()
    {
        $usuario = Auth::user();
        $productos = $usuario->carrito()->withPivot('cantidad')->get();
        return view('carrito.index', compact('productos'));
    }
}
