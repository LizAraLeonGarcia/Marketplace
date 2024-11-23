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
                                        <strong>Últimos 4 dígitos:</strong> ****{{ $method['last4'] ?? '****' }}<br>
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

        // Ahora confirmamos el SetupIntent con el método de pago creado
        stripe.confirmSetupIntent(clientSecret, {
            payment_method: paymentMethod.id
        }).then(function(result) {
            if (result.error) {
                // Si hay un error, lo mostramos
                console.error(result.error.message);
                alert('Hubo un problema al guardar el método de pago: ' + result.error.message);
            } else {
                // Si la confirmación es exitosa, asignamos el paymentMethodId al campo oculto
                document.getElementById('paymentMethodId').value = paymentMethod.id;

                // Ahora podemos enviar el formulario
                paymentForm.submit();  // Se envía el formulario
            }
        });
    });
</script>
@endsection
