<?php

namespace App\Http\Controllers;

use Stripe\PaymentMethod;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\SetupIntent;
use Auth;

class PaymentMethodController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();

        // Si el usuario no tiene un Stripe ID, lo creamos
        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        // Configuramos la API de Stripe y creamos el SetupIntent
        Stripe::setApiKey(env('STRIPE_SECRET'));
        // Crear un SetupIntent para este cliente
        $setupIntent = SetupIntent::create([
            'customer' => $user->stripe_id,
        ]);
        // Pasar el client_secret al frontend
        return view('metodo-de-pago', [
            'setupIntent' => $setupIntent
        ]);
    }

    public function store(Request $request)
    {
        // Validamos la entrada del usuario
        $request->validate([
            'paymentMethodId' => 'required|string',
        ]);

        $user = Auth::user();

        // Si no tiene un stripe_id, lo creamos
        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        // Obtenemos el método de pago desde Stripe
        $paymentMethod = PaymentMethod::retrieve($request->paymentMethodId);

        // Asociamos el método de pago al cliente
        $user->addPaymentMethod($paymentMethod);

        // Establecemos como predeterminado si es tarjeta
        if ($paymentMethod->card) {
            $user->updateDefaultPaymentMethod($paymentMethod->id);
        }

        return redirect()
            ->route('metodo-de-pago.create')
            ->with('success', 'Método de pago guardado con éxito.');
    }


        public function showMetodoDePagoForm()
    {
        // Configurar Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Generar un SetupIntent
        $setupIntent = SetupIntent::create([
            'customer' => auth()->user()->stripe_id,
        ]);

        // Obtener métodos de pago guardados del usuario autenticado
        $user = auth()->user();
        $paymentMethods = $user->paymentMethods() ?? []; // Asegúrate de tener implementado este método o ajusta la lógica.
        dd($paymentMethods);

        // Pasar datos a la vista
        return view('cuenta.metodo-de-pago', [
            'setupIntent' => $setupIntent,
            'paymentMethods' => $paymentMethods,
        ]);
    }
    /**
     * Maneja el almacenamiento de un método de pago.
     */
    public function storeMetodoDePago(Request $request)
    {
        // Lógica para guardar el método de pago.
        return back()->with('success', 'Método de pago guardado correctamente.');
    }
}
