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
        // Calcula el total para productos seleccionados
        $total = $carritos->sum(function ($producto) {
            return $producto->precio * $producto->pivot->cantidad;
        });

        // Obtener los métodos de pago del usuario autenticado
        $user = auth()->user();
        $paymentMethods = $user->paymentMethods(); // Ajusta según tu implementación de Stripe o tu modelo User

        return view('carrito.index', compact('carritos', 'total', 'paymentMethods'));        
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
        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }        

        $user->createAsStripeCustomer();

        $productosSeleccionados = $request->input('productos_seleccionados'); // IDs de productos seleccionados
        $paymentMethodId = $request->input('payment_method_id'); // ID del método de pago seleccionado

        if (!$paymentMethodId) {
            return back()->withErrors(['error' => 'Debes seleccionar un método de pago.']);
        }

        try {
            $total = 0;

            foreach ($productosSeleccionados as $productoId) {
                $producto = Producto::findOrFail($productoId);
                $total += $producto->precio; // Ajustar según cantidad si aplica
            }

            $user = auth()->user();
            $paymentMethods = $user->paymentMethods();
            $stripeCustomerId = $user->stripe_customer_id;

            if (!$stripeCustomerId) {
                // Si no tiene un cliente en Stripe, créalo
                $stripeCustomer = \Stripe\Customer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);
                $stripeCustomerId = $stripeCustomer->id;
                $user->stripe_customer_id = $stripeCustomerId;
                $user->save();
            }

            \Stripe\PaymentIntent::create([
                'amount' => $total * 100, // En centavos
                'currency' => 'mxn',
                'customer' => $stripeCustomerId,
                'payment_method' => $paymentMethodId,
                'off_session' => true,
                'confirm' => true,
            ]);

            return redirect()->route('carrito.exitoso')->with('success', 'Pago realizado con éxito.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al procesar el pago: ' . $e->getMessage()]);
        }
    }

    public function pagoExitoso()
    {
        return view('pago-exitoso')->with('message', '¡Tu pago fue exitoso!');
    }
}
