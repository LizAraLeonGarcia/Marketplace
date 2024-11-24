<?php

namespace App\Http\Controllers;

use Stripe\PaymentMethod as StripePaymentMethod;
use Stripe\Stripe;
use Stripe\SetupIntent;
use Illuminate\Http\Request;
use Auth;
use App\Models\PaymentMethod as PaymentMethodModel; // Asegúrate de usar el alias adecuado para el modelo

class PaymentMethodController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $paymentMethods = $user->paymentMethods()->get(); // Obtiene la colección de métodos de pago

        return view('metodo-de-pago.show', compact('paymentMethods'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        // Si el usuario no tiene un Stripe ID, lo creamos
        
        if (!$user->stripe_id) {
            $user->createAsStripeCustomer();
            if (!$user->stripe_id) {
                throw new \Exception('No se pudo crear un cliente de Stripe para este usuario.');
            }
        }        
        // Configuramos la API de Stripe y creamos el SetupIntent Stripe::setApiKey(env('STRIPE_SECRET'));
        // Genera un nuevo SetupIntent

        try {
            $setupIntent = SetupIntent::create([
                'customer' => $user->stripe_id,
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Manejar el error aquí
            return back()->withErrors(['error' => 'Error al crear el SetupIntent: ' . $e->getMessage()]);
        }
        
        // Pasar el client_secret al frontend
        return view('cuenta.metodo-de-pago', [
            'setupIntent' => $setupIntent
        ]);
    }

    public function store(Request $request)
    {
        $paymentMethodId = $request->paymentMethodId;
        $user = auth()->user();
        // Verifica que el ID de PaymentMethod esté presente
        if (!$paymentMethodId) {
            return back()->withErrors(['error' => 'No se proporcionó un método de pago válido.']);
        }

        // Configurar Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Usar la clase Stripe\PaymentMethod para recuperar el método de pago
            $stripePaymentMethod = StripePaymentMethod::retrieve($paymentMethodId);
    
            // Adjuntar el método de pago al cliente en Stripe
            $stripePaymentMethod->attach(['customer' => $user->stripe_id]);
    
            // Guardar el método de pago en la base de datos
            PaymentMethodModel::create([
                'user_id' => $user->id,
                'stripe_payment_method_id' => $paymentMethodId,
                'brand' => $stripePaymentMethod->card->brand,
                'last4' => $stripePaymentMethod->card->last4,
                'exp_month' => $stripePaymentMethod->card->exp_month,
                'exp_year' => $stripePaymentMethod->card->exp_year,
                'is_default' => true, // Marcarlo como predeterminado
            ]);
             // Guardar el método de pago en Stripe
            $user->addPaymentMethod($request->paymentMethodId);
            session()->flash('success', 'Método de pago guardado correctamente.');
            return redirect()->route('metodo-de-pago.show');
    
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Captura y maneja el error de Stripe
            session()->flash('error', 'Hubo un error al procesar el pago: ' . $e->getMessage());
            return redirect()->route('metodo-de-pago.show');
        }
    }

    public function showMetodoDePagoForm()
    {
        $user = Auth::user();
        //$paymentMethods = $user->paymentMethods; // Usa la relación
        $paymentMethods = auth()->user()->paymentMethods()->get();
        // Eliminar duplicados usando el campo 'stripe_payment_method_id'
        $paymentMethods = collect($paymentMethods)->unique('stripe_payment_method_id')->values();

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $setupIntent = SetupIntent::create([
            'customer' => $user->stripe_id,
        ]);

        return view('cuenta.metodo-de-pago', [
            'setupIntent' => $setupIntent,
            'paymentMethods' => $paymentMethods,
        ]);
    }


}