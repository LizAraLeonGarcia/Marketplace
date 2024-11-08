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
        $user = auth()->user(); // Recuperar el usuario autenticado
        // Validar que hay productos seleccionados
        $productosSeleccionados = $request->input('productos_seleccionados', []);
        if (empty($productosSeleccionados)) {
            return redirect()->back()->with('error', 'No se seleccionaron productos para comprar.');
        }
        // Validar los productos seleccionados
        $request->validate([
            'productos_seleccionados' => 'required|array|min:1',
            'productos_seleccionados.*' => 'exists:productos,id',
            'cantidad_*' => 'integer|min:1',
        ]);
        // Crear el pedido (order)
        $order = Order::create([
            'buyer_id' => $user->id,
            'status' => 'pending', // Estado de "pendiente"
        ]);
        // Asociar los productos seleccionados con el pedido
        foreach ($productosSeleccionados as $productoId) {
            $producto = Producto::find($productoId);
            // Obtener la cantidad del producto desde el carrito
            $cantidad = $user->carritos()->where('productos.id', $productoId)->first()->pivot->cantidad ?? 1;
        
            // Aquí se verifica si el producto ya está en el pedido
            $existingOrderItem = $order->items()->where('product_id', $producto->id)->first();
            if ($existingOrderItem) {
                $existingOrderItem->update([
                    'cantidad' => $existingOrderItem->cantidad + $cantidad,
                    'precio' => $producto->precio,
                ]);
            } else {
                $order->items()->create([
                    'product_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio' => $producto->precio,
                ]);
            }
        }
        // Limpiar el carrito después de hacer el pedido
        $user->carritos()->detach($productosSeleccionados);
        // Redirigir al usuario a su perfil como comprador
        return redirect()->route('carrito.index')->with('success', 'Pedido realizado con éxito.');
    }
    // metodo de pago ..........................................................................................................................
    public function checkout(Request $request)
    {
        $user = $request->user();
        
        if (!$user->stripe_customer_id) {
            return redirect()->route('metodo-de-pago.show')->withErrors(['error' => 'Agrega un método de pago antes de continuar.']);
        }
        // Resumen de productos en el carrito
        $productos = $user->carritos()->with(['product'])->get();
        // Calcula el total del pedido
        $total = $productos->sum(function ($producto) {
            return $producto->precio * $producto->pivot->cantidad;
        });
        // Realiza el pago a través de Stripe
        $paymentIntent = $this->realizarPago($user, $total);
        // Si el pago es exitoso, marca el pedido como pagado
        if ($paymentIntent->status == 'succeeded') {
            // Aquí se crea el pedido y los productos se asocian con sus vendedores
            return redirect()->route('comprador.perfil')->with('success', 'Pedido realizado con éxito y pagado.');
        } else {
            return redirect()->back()->with('error', 'Error en el pago.');
        }
    }
}
