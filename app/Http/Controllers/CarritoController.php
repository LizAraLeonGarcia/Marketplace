<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
        // Calcula el total para productos seleccionados (usualmente manejado en la vista al seleccionar los productos)
        $total = $carritos->sum(function ($producto) {
            return $producto->precio * $producto->pivot->cantidad;
        });
        
        return view('carrito.index', compact('carritos', 'total')); 
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

        return redirect()->route('productos.index')->with('success', 'Producto agregado al carrito');
    }
    // -------------------------------------------------------------------------------------------------------------------------------- eliminar
    public function eliminar($producto_id)
    {
        auth()->user()->carritos()->detach($producto_id);
        return redirect()->route('carrito.index')->with('success', 'Producto eliminado del carrito');
    }
    //
    public function eliminarSeleccionados(Request $request)
    {
        // Validar que los productos seleccionados estén presentes
        $request->validate([
            'productos_seleccionados' => 'required|array|min:1',
            'productos_seleccionados.*' => 'exists:productos,id',
        ]);
        // Obtener los productos seleccionados
        $productosIds = $request->input('productos_seleccionados');
        // Eliminar los productos seleccionados del carrito del usuario autenticado
        Auth::user()->carritos()->detach($productosIds);
        // Redirigir al carrito con un mensaje de éxito
        return redirect()->route('carrito.index')->with('success', 'Productos eliminados del carrito con éxito.');
    }
    // ------------------------------------------------------------------------------------------------------------- mostrar producto especifico
    public function mostrar()
    {
        $usuario = Auth::user();
        $productos = $usuario->carritos()->withPivot('cantidad')->get();
        return view('carrito.index', compact('productos'));
    }
    // ---------------------------------------------------------------------------------------------------------------- pagar el o los productos
    public function pagar(Request $request)
    {
        $productosSeleccionados = $request->input('productos_seleccionados', []);
        
        if (empty($productosSeleccionados)) {
            return redirect()->back()->with('error', 'No has seleccionado ningún producto para pagar.');
        }
        // Crear el pedido (order)
        $order = Order::create([
            'buyer_id' => Auth::id(),
            'status' => 'pending', // Estado de "pendiente" (puede ser "completed" después del pago).
        ]);
        // Asociar los productos seleccionados con el pedido
        foreach ($productosSeleccionados as $productoId) {
            $producto = Producto::find($productoId);
            if ($producto) {
                $cantidad = $request->input('cantidad_' . $productoId, 1); 
                $order->products()->attach($producto, ['cantidad' => $cantidad]);
            }
        }
        // Limpiar el carrito después de hacer el pedido
        Auth::user()->carritos()->detach($productosSeleccionados);
        // Redirigir al usuario a su perfil como comprador
        return redirect()->route('cuenta.comprador')->with('success', 'Pedido realizado con éxito.');
    }
    // metodo de pago ..........................................................................................................................
    public function checkout(Request $request)
    {
        $user = $request->user();
        if (!$user->stripe_customer_id) {
            return redirect()->route('metodo-de-pago.show')->withErrors(['error' => 'Agrega un método de pago antes de continuar.']);
        }
        // Muestra el resumen del carrito y confirma el pago usando el método predeterminado
        return view('checkout', [
            'metodoDePago' => $user->metodoDePago(), // Método de pago predeterminado
            'cart' => auth()->user()->carritos,
        ]);
    }
}
