@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Menú lateral -->
    <div class="custom-menu">
        @include('partials.menu-lateral') <!-- Menú lateral -->
    </div> 
    <!-- Contenido -->
    <div class="contenidoPrincipal">
        <h2>Agregar método de pago</h2>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="row align-items-center">
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <img src="{{ asset('assets/img/metodoPago1.png') }}" alt="Descripción de la imagen" class="img-fluid">
            </div>
            <div class="col-md-8">
                <form id="metodo-de-pago-form" action="{{ route('metodo-de-pago.store') }}" method="POST">
                    @csrf
                    <label for="payment-method">Selecciona un método de pago:</label>
                    <select id="payment-method" name="payment_method">
                        <option value="card">Tarjeta (Crédito/Débito)</option>
                        <option value="bank_transfer">Transferencia Bancaria</option>
                        <option value="google_pay">Google Pay</option>
                        <option value="apple_pay">Apple Pay</option>
                    </select>

                    <div id="card-element"></div>
                    <div id="card-errors" class="alert-error" role="alert"></div>

                    <button type="submit">Guardar Método de Pago</button>
                    <input type="hidden" name="paymentMethodId" id="paymentMethodId">
                </form>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-8 saved-methods-section">
                <h3 class="mb-4"><strong>Métodos de pago guardados</strong></h3>
                @if (count($paymentMethods) > 0)
                    <div class="list-group">
                        @foreach ($paymentMethods as $method)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Marca:</strong> {{ $method['brand'] ?? 'Desconocida' }}<br>
                                    <strong>Últimos 4 digitos:</strong> ****{{ $method['last4'] ?? '****' }}<br>
                                    <strong>Expiración:</strong> {{ $method['exp_month'] ?? '??' }}/{{ $method['exp_year'] ?? '??' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="alert alert-warning mt-3">No tienes métodos de pago registrados.</p>
                @endif
            </div>
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <img src="{{ asset('assets/img/metodoPago2.png') }}" alt="Descripción de la imagen" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    // Configura Stripe con tu clave pública
    var stripe = Stripe('pk_test_51QHCEnEOSd6PZ2Eh0p78RV4cpb9OBorZRxUkdUUkOMbmmHsDGdUPenYmnSZLOhECTe8ttUF2bI3vg0qeuNDjJCrd00M6gG3EBF'); 

    // Inicializar elementos de Stripe
    var elements = stripe.elements();
    var card = elements.create('card'); 
    card.mount('#card-element'); // Monta el campo de tarjeta en el contenedor

    // Obtener el formulario y asignar evento submit
    var paymentForm = document.getElementById('metodo-de-pago-form');
    paymentForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Evita el envío del formulario por defecto

        // Deshabilitar el botón de envío para evitar envíos múltiples
        const submitButton = document.querySelector('button[type="submit"]');
        submitButton.disabled = true;

        try {
            // Obtén el client_secret desde tu backend (pasado a la vista Blade)
            var clientSecret = "{{ $setupIntent->client_secret }}";

            // Crear método de pago
            const { paymentMethod, error: paymentMethodError } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
            });

            // Manejar error en creación de método de pago
            if (paymentMethodError) {
                console.error('Error al crear el método de pago:', paymentMethodError.message);
                alert('Error al crear el método de pago: ' + paymentMethodError.message);
                submitButton.disabled = false; // Rehabilitar el botón
                return;
            }

            // Confirmar el SetupIntent con el método de pago creado
            const { setupIntent, error: confirmError } = await stripe.confirmCardSetup(clientSecret, {
                payment_method: paymentMethod.id,
            });

            // Manejar error al confirmar el SetupIntent
            if (confirmError) {
                console.error('Error al confirmar el SetupIntent:', confirmError.message);
                alert('Hubo un problema al guardar el método de pago: ' + confirmError.message);
                submitButton.disabled = false; // Rehabilitar el botón
                return;
            }

            // SetupIntent confirmado exitosamente
            console.log('SetupIntent confirmado:', setupIntent);

            // Agregar el paymentMethodId al formulario para enviarlo al backend
            document.getElementById('paymentMethodId').value = paymentMethod.id;

            // Enviar el formulario al backend
            paymentForm.submit();
        } catch (error) {
            if (error.message.includes('SetupIntent has already succeeded')) {
                alert('Este SetupIntent ya fue procesado. Recarga la página para crear uno nuevo.');
            } else {
                alert('Error inesperado: ' + error.message);
            }
            console.error('Error:', error);
            // Rehabilitar el botón
            submitButton.disabled = false; 
        }
    });
</script>
@endsection
