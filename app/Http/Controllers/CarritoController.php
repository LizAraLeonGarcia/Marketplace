<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    // --------------------------------------------------------------------------------------------------------------------------- mostrar todos
    public function index()
    {
        // Obtiene los productos en el carrito del usuario autenticado
        $carritos = auth()->user()->carritos()->with(['categoria'])->withPivot('cantidad')->get();
        // Pasa la variable $carrito a la vista
        return view('carrito.index', compact('carritos')); 
    }
    // --------------------------------------------------------------------------------------------------------------------------------- agregar
    public function agregar(Request $request, $producto_id)
    {
        $request->validate(['cantidad' => 'required|integer|min:1']);
        
        $cantidad = $request->input('cantidad', 1);
        // Asegurar que el producto existe
        $producto = Producto::findOrFail($producto_id);
        // Agrega el producto al carrito con la cantidad especificada
        auth()->user()->carritos()->syncWithoutDetaching([
            $producto->id => ['cantidad' => $cantidad]
        ]);

        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito');
    }
    // -------------------------------------------------------------------------------------------------------------------------------- eliminar
    public function eliminar($producto_id)
    {
        auth()->user()->carritos()->detach($producto_id);
        return redirect()->route('carrito.index')->with('success', 'Producto eliminado del carrito');
    }
    
    public function eliminarSeleccionados(Request $request)
    {
        $productosSeleccionados = $request->input('productos_seleccionados', []);
        if (!empty($productosSeleccionados)) {
            // Aquí eliminamos los productos seleccionados del carrito del usuario
            auth()->user()->carrito()->detach($productosSeleccionados);
        }
        return redirect()->route('carrito.index')->with('success', 'Productos eliminados del carrito.');
    }
    // --------------------------------------------------------------------------------------------------------------------- producto especifico
    public function mostrar()
    {
        $usuario = Auth::user();
        $productos = $usuario->carritos()->withPivot('cantidad')->get();
        return view('carrito.index', compact('productos'));
    }
    // metodo de pago
    public function checkout(Request $request)
    {
        $user = $request->user();
        if (!$user->stripe_customer_id) {
            return redirect()->route('metodo-de-pago.show')->withErrors(['error' => 'Agrega un método de pago antes de continuar.']);
        }
        // Muestra el resumen del carrito y confirma el pago usando el método predeterminado
        return view('checkout', [
            'metodoDePago' => $user->metodoDePago(), // Método de pago predeterminado
            'cart' => session('cart'),
        ]);
    }
}
