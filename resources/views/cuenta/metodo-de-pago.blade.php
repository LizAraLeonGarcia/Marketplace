@extends('layouts.app')

@section('content')
<style>
    .col-md-9, .col-lg-10 {
        padding: 0; /* eliminar el padding para evitar espacios innecesarios */
        min-height: 100vh; /* área principal ocupa toda la altura */
        margin-left: 230px; /* área principal después del menú */
        background-color: #c1c6ca; /* color de fondo del body */
    }

    .contenido {
        overflow-x: hidden; /* Oculta cualquier desbordamiento horizontal */
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .alert-error {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        padding: 10px;
        margin-top: 10px;
        border-radius: 5px;
    }

    button[type="submit"] {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%; /* Ancho completo del botón */
        margin-top: 20px;
        font-size: 18px;
    }

    button[type="submit"]:hover {
        background-color: #218838;
    }

    #card-element {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        margin-top: 10px;
        background-color: #fff;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    label {
        font-weight: bold;
        font-size: 24px;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    select, input[type="text"] {
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #ffffff;
        width: 100%;
        font-size: 16px;
        margin-bottom: 15px;
    }

    .saved-methods-section {
        margin-top: 30px;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .saved-methods-section h3 {
        font-size: 22px;
        color: #444;
        text-align: center;
        margin-bottom: 15px;
    }

    .card.payment-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        background-color: #fafafa;
        margin-bottom: 10px;
    }

    .card.payment-card p {
        margin: 5px 0;
        font-size: 16px;
    }
    /* Imagenes */
    .col-md-4 img {
        max-width: 250px;
        margin: 0 auto;
        display: block;
        padding: 10px;
    }
</style>

<div class="contenido">
    <h2>Agregar método de pago</h2>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
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

    <div class="row saved-methods-section">
        <div class="col-md-8">
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
