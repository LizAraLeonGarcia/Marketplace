<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer;

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
        // Verifica que se han seleccionado productos
        if (!$request->has('productos_seleccionados') || empty($request->productos_seleccionados)) {
            return back()->with('error', 'No seleccionaste productos para pagar.');
        }

        // Obtén el usuario autenticado
        $user = auth()->user();

        // Valida los productos seleccionados
        $productosIds = $request->input('productos_seleccionados');
        $productos = $user->carritos()->whereIn('productos.id', $productosIds)->withPivot('cantidad')->get();

        if ($productos->isEmpty()) {
            return back()->with('error', 'No seleccionaste productos para pagar.');
        }

        // Calcula el total
        $total = 0;
        foreach ($productos as $producto) {
            $total += $producto->precio * $producto->pivot->cantidad;
        }

        try {
            // Crear el PaymentIntent con Stripe
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $paymentIntent = PaymentIntent::create([
                'amount' => $total * 100, // Total en centavos
                'currency' => 'usd',
                'customer' => $user->stripe_customer_id,
                'payment_method' => $user->default_payment_method_id,
                'off_session' => true,
                'confirm' => true,
            ]);

            // Verificar si el pago fue exitoso
            if ($paymentIntent->status == 'succeeded') {
                // Elimina productos del carrito tras el pago exitoso
                $user->carritos()->detach($productosIds);
                return redirect()->route('cuenta.comprador')->with('success', 'Pago realizado con éxito.');
            } else {
                return back()->with('error', 'Error al procesar el pago.');
            }

        } catch (\Exception $e) {
            // Capturar cualquier error y mostrarlo al usuario
            return back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
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
