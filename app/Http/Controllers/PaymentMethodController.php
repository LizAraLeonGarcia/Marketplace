<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\SetupIntent;
use Illuminate\Http\Request;
use Auth;
use App\Models\PaymentMethod as PaymentMethodModel;
use \Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class PaymentMethodController extends Controller
{
    /**
     * Mostrar los métodos de pago del usuario
     */
    public function index()
    {
        $user = auth()->user();
        $paymentMethods = $user->paymentMethods()->get(); // Obtiene la colección de métodos de pago

        return view('metodo-de-pago.show', compact('paymentMethods'));
    }

    /**
     * Mostrar el formulario para agregar un nuevo método de pago
     */
    public function showMetodoDePagoForm()
    {
        $user = Auth::user();

        // Asegúrate de que el usuario tiene un Stripe ID
        if (!$user->stripe_id) {
            $user->createAsStripeCustomer();
        }

        try {
            // Crear un nuevo SetupIntent
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $setupIntent = SetupIntent::create([
                'customer' => $user->stripe_id,
            ]);
        } catch (ApiErrorException $e) {
            return back()->withErrors(['error' => 'Error al crear el SetupIntent: ' . $e->getMessage()]);
        }

        // Obtén los métodos de pago existentes
        $paymentMethods = $user->paymentMethods()->get();

        return view('cuenta.metodo-de-pago', [
            'setupIntent' => $setupIntent,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    /**
     * Procesar el nuevo método de pago
     */
    public function store(Request $request)
{
    $user = Auth::user();

    // Validar el ID del método de pago enviado desde el frontend
    $request->validate([
        'paymentMethodId' => 'required|string',
    ]);

    try {
        // Agregar el método de pago al usuario
        $paymentMethod = $user->addPaymentMethod($request->paymentMethodId);

        if ($paymentMethod) {
            // Obtener la información de la tarjeta
            $brand = $paymentMethod->card->brand ?? null; // Marca de la tarjeta (Visa, Mastercard, etc.)
            $last4 = $paymentMethod->card->last4 ?? null; // Últimos 4 dígitos de la tarjeta
            $expMonth = $paymentMethod->card->exp_month ?? null; // Mes de expiración
            $expYear = $paymentMethod->card->exp_year ?? null; // Año de expiración

            if (!$last4 || !$brand || !$expMonth || !$expYear) {
                return response()->json(['success' => false, 'message' => 'No se pudo obtener la información de la tarjeta.']);
            }

            // Crear un registro en la tabla PaymentMethod
            $paymentMethodRecord = $user->paymentMethods()->create([
                'stripe_payment_method_id' => $paymentMethod->id,
                'brand' => $brand,
                'last4' => $last4,
                'exp_month' => $expMonth,
                'exp_year' => $expYear,
                'is_default' => false, 
            ]);
            // Establecer este método de pago como el predeterminado
            $user->updateDefaultPaymentMethod($paymentMethod->id);
            //return response()->json(['success' => true, 'message' => 'Método de pago guardado correctamente.']);
            return redirect()->back()->with('success', 'Método de pago guardado correctamente.');
        } else {
            return response()->json(['success' => false, 'message' => 'Hubo un error al guardar el método de pago.']);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error inesperado: ' . $e->getMessage()]);
    }
}


}