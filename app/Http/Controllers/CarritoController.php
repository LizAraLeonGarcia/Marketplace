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
        if (!$request->has('productos_seleccionados') || empty($request->input('productos_seleccionados'))) {
            return back()->with('error', 'Debes seleccionar al menos un producto para pagar.');
        }

        // Decodifica el JSON de los productos seleccionados
        $productosSeleccionados = json_decode($request->input('productos_seleccionados'), true);

        if (!is_array($productosSeleccionados) || empty($productosSeleccionados)) {
            return back()->with('error', 'El formato de los productos seleccionados es inválido.');
        }

        // Extrae los IDs de los productos
        $productosIds = array_column($productosSeleccionados, 'id');
        $user = auth()->user();

        // Verifica que los productos seleccionados pertenecen al carrito del usuario
        $productos = $user->carritos()->whereIn('productos.id', $productosIds)->withPivot('cantidad')->get();

        if ($productos->isEmpty()) {
            return back()->with('error', 'Algunos productos seleccionados no están disponibles en tu carrito.');
        }

        // Calcula el total
        $total = $productos->sum(function ($producto) use ($productosSeleccionados) {
            $cantidadSeleccionada = collect($productosSeleccionados)
                ->firstWhere('id', $producto->id)['cantidad'] ?? 0;
            return $producto->precio * $cantidadSeleccionada;
        });

        // (Aquí se puede realizar el proceso de pago usando Stripe u otro método)
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $paymentIntent = PaymentIntent::create([
                'amount' => $total * 100, // Total en centavos
                'currency' => 'usd',
            ]);

            if ($paymentIntent->status === 'succeeded') {
                // Eliminar los productos pagados del carrito
                $user->carritos()->detach($productosIds);
                return redirect()->route('carrito.index')->with('success', 'Pago realizado con éxito.');
            }
        } catch (\Exception $e) {
            return redirect()->route('carrito.index')->with('error', 'Error al procesar el pago: ' . $e->getMessage());
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
