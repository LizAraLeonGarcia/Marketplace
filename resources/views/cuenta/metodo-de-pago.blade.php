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
                    <h3><strong>Métodos de pago guardados</strong></h3>
                    @if (count($paymentMethods) > 0)
                        @foreach ($paymentMethods as $method)
                            <div class="card payment-card">
                                <p><strong>Tarjeta:</strong> **** **** **** {{ $method->card->last4 }}</p>
                                <p><strong>Expira:</strong> {{ $method->card->exp_month }}/{{ $method->card->exp_year }}</p>
                                <p><strong>Marca:</strong> {{ $method->card->brand }}</p>
                            </div>
                        @endforeach
                    @else
                        <p>No tienes ningún método de pago guardado.</p>
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
    // Configura Stripe con clave pública
    var stripe = Stripe('pk_test_51QHCEnEOSd6PZ2Eh0p78RV4cpb9OBorZRxUkdUUkOMbmmHsDGdUPenYmnSZLOhECTe8ttUF2bI3vg0qeuNDjJCrd00M6gG3EBF'); 

    var elements = stripe.elements();
    var card = elements.create('card');
    card.mount('#card-element'); // Monta el campo de la tarjeta

    var paymentForm = document.getElementById('metodo-de-pago-form');
    paymentForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Prevenir envío del formulario

        // Obtén el client_secret de SetupIntent desde el backend (pasado a la vista)
        var clientSecret = "{{ $setupIntent->client_secret }}"; // Este es el valor que se pasa desde el controlador
        // Crea el método de pago
        const { paymentMethod, error } = await stripe.createPaymentMethod('card', card);

        if (error) {
            console.error(error.message);
            alert('Error al crear el método de pago: ' + error.message);
            return;
        }

        // Ahora confirma el SetupIntent con el método de pago creado
        stripe.confirmSetupIntent(clientSecret, {
            payment_method: paymentMethod.id
        }).then(function(result) {
            if (result.error) {
                // Si hay un error, lo mostramos
                console.error(result.error.message);
                alert('Hubo un problema al guardar el método de pago: ' + result.error.message);
            } else {
                // Si la confirmación es exitosa, redirigimos o mostramos un mensaje
                console.log('Método de pago guardado exitosamente.');
                alert('Método de pago guardado correctamente');
                // Redirigir o hacer algo más
            }
        });
    });
</script>
@endsection
