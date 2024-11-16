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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('metodo-de-pago-form');
        const paymentMethodSelect = document.getElementById('payment-method');
        const cardContainer = document.getElementById('card-element');

        paymentMethodSelect.addEventListener('change', () => {
            if (paymentMethodSelect.value === 'card') {
                cardContainer.style.display = 'block';
            } else {
                cardContainer.style.display = 'none';
            }
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const selectedMethod = paymentMethodSelect.value;

            if (selectedMethod === 'card') {
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    '{{ $intent->client_secret }}',
                    {
                        payment_method: {
                            card: cardElement,
                            billing_details: { name: '{{ auth()->user()->name }}' }
                        },
                    }
                );

                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                } else {
                    document.getElementById('paymentMethodId').value = setupIntent.payment_method;
                    form.submit();
                }
            } else if (selectedMethod === 'bank_transfer') {
                alert("Para completar la transferencia bancaria, sigue las instrucciones enviadas a tu correo.");
                form.submit();
            } else if (selectedMethod === 'google_pay') {
                alert("Redirigiendo a Google Pay...");
                form.submit();
            } else if (selectedMethod === 'apple_pay') {
                alert("Redirigiendo a Apple Pay...");
                form.submit();
            }
        });
    });
</script>
@endsection
