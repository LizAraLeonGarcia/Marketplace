<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;

class MetodoDePagoController extends Controller
{
    public function showMetodoDePagoForm()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $intent = \Stripe\SetupIntent::create([
            'customer' => auth()->user()->stripe_customer_id,
        ]);

        return view('cuenta.metodo-de-pago', [
            'intent' => $intent,
        ]);
    }

    public function storeMetodoDePago(Request $request)
    {
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
