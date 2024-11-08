<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;

class MetodoDePagoController extends Controller
{
    // ............................................................................................................... mostrar el metodo de pago
    public function showMetodoDePagoForm()
    {
        $user = auth()->user();
        Stripe::setApiKey(env('STRIPE_SECRET'));
        // Crear cliente en Stripe si no existe
        if (!$user->stripe_customer_id) {
            $customer = Customer::create([
                'email' => $user->email,
            ]);
            $user->stripe_customer_id = $customer->id;
            $user->save();
        }
        // Crear SetupIntent para capturar un método de pago nuevo
        $intent = \Stripe\SetupIntent::create([
            'customer' => $user->stripe_customer_id,
        ]);
        // Obtener métodos de pago existentes
        $paymentMethods = PaymentMethod::all([
            'customer' => $user->stripe_customer_id,
            'type' => 'card',  // Filtra solo tarjetas de crédito/débito
        ]);
        // Pasar los métodos de pago a la vista
        return view('cuenta.metodo-de-pago', ['intent' => $intent,'paymentMethods' => $paymentMethods->data, ]);
    }
    // ................................................................................................................................... store
    public function storeMetodoDePago(Request $request)
    {
        if (empty($request->paymentMethodId)) {
            return back()->withErrors(['error' => 'El ID del método de pago no es válido.']);
        }        

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Crear el cliente de Stripe si no existe uno
            $user = $request->user();
            if (!$user->stripe_customer_id) {
                $customer = Customer::create([
                    'email' => $user->email,
                ]);

                $user->stripe_customer_id = $customer->id;
                $user->save();
            }
            // Asocia el método de pago al cliente
            $paymentMethod = PaymentMethod::retrieve($request->paymentMethodId);
            $paymentMethod->attach(['customer' => $user->stripe_customer_id]);
            // Establece el método de pago como predeterminado
            Customer::update($user->stripe_customer_id, [
                'invoice_settings' => ['default_payment_method' => $paymentMethod->id],
            ]);

            return redirect()->back()->with('success', 'Método de pago guardado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
