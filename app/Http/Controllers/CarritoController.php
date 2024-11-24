<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;

class CarritoController extends Controller
{
    // --------------------------------------------------------------------------------------------------------------------------- mostrar todos
    public function index()
    {
        // Obtiene los productos en el carrito del usuario autenticado
        $carritos = auth()->user()->carritos()->with(['categoria'])->withPivot('cantidad')->get();
        
        // Obtener los métodos de pago del usuario autenticado
        $user = auth()->user();
        $paymentMethods = $user->paymentMethods(); // Ajusta según tu implementación de Stripe o tu modelo User

        // Obtén los productos seleccionados (esto puede ser adaptado según tu lógica)
        $productosSeleccionados = $carritos->map(function ($producto) {
            return $producto->id; // Aquí puedes personalizar el arreglo de productos seleccionados
        });

        return view('carrito.index', compact('carritos', 'paymentMethods', 'productosSeleccionados'));
    }
    // ------------------------------------------------------------------------------------------------------------- mostrar producto especifico
    public function mostrar()
    {
        $usuario = Auth::user();
        $productos = $usuario->carritos()->withPivot('cantidad')->get();
        return view('carrito.index', compact('productos'));
    }
    // --------------------------------------------------------------------------------------------------------------------------------- agregar
    public function agregar(Request $request, $producto_id)
    {
        $request->validate(['cantidad' => 'required|integer|min:1']);
        
        $cantidad = $request->input('cantidad', 1);
        // Asegurar que el producto existe
        $producto = Producto::findOrFail($producto_id);
        // Verifica si el producto ya está en el carrito
        $carrito = auth()->user()->carritos()->where('producto_id', $producto->id)->first();

        if ($carrito) {
            // Si el producto ya está en el carrito, actualiza la cantidad sumando la cantidad nueva
            $nuevaCantidad = $carrito->pivot->cantidad + $cantidad;
            auth()->user()->carritos()->updateExistingPivot($producto->id, ['cantidad' => $carrito->pivot->cantidad + $cantidad]);
        } else {
            // Si el producto no está en el carrito, agrega el producto con la cantidad especificada
            auth()->user()->carritos()->attach($producto->id, ['cantidad' => $cantidad]);
        }

        return redirect()->route('productos.index')->with('success', 'Producto agregado al carrito');
    }
    // ------------------------------------------------------------------------------------------------------------ eliminar producto especifico
    public function eliminar($producto)
    {
        // Obtener el carrito del usuario autenticado
        $user = auth()->user();
        // Eliminar el producto del carrito del usuario
        $user->carritos()->detach($producto);
        // Redirigir con un mensaje de éxito
        return redirect()->route('carrito.index')->with('success', 'Producto eliminado del carrito con éxito.');
    }
    // ---------------------------------------------------------------------------------------------------------------- pagar el o los productos
    public function pagar(Request $request)
{
    $productosSeleccionados = json_decode($request->input('productos_seleccionados'), true);

    if ($productosSeleccionados) {
        // Elimina los productos seleccionados del carrito usando la relación del usuario
        foreach ($productosSeleccionados as $productoId) {
            auth()->user()->carritos()->detach($productoId);
        }

        // Redirige a la vista de pago exitoso
        return redirect()->route('carrito.pago-exitoso')->with('success', 'Pago procesado con éxito. Los productos han sido removidos del carrito.');
    }

    // Manejar casos en los que no se seleccionaron productos
    return back()->with('error', 'No se seleccionaron productos para pagar.');
}


    public function pagoExitoso(Request $request)
    {
        return view('carrito.pago-exitoso');
    }
}