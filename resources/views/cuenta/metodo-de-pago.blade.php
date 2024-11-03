@extends('layouts.app')

@section('content')
<style>
    .col-md-9, .col-lg-10 {
        padding: 0;
        min-height: 100vh;
        margin-left: 230px;
        background-color: #c1c6ca;
    }
    .contenido {
        padding: 20px;
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
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    button[type="submit"]:hover {
        background-color: #218838;
    }
    #card-element {
        padding: 10px;
        border: 1px solid #ccc; 
        border-radius: 4px; 
        margin-top: 10px; 
        background-color: white; 
    }
</style>

<div class="contenido">
    <h2>Agregar Método de Pago</h2>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-4 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/img/metodoPago.png') }}" alt="Descripción de la imagen" class="img-fluid">
        </div>
        <div class="col-md-8">
            <form id="metodo-de-pago-form" action="{{ route('metodo-de-pago.store') }}" method="POST">
                @csrf
                <div id="card-element"></div>
                <button type="submit">Guardar Método de Pago</button>
                <div id="card-errors" class="alert-error" role="alert"></div>
                <input type="hidden" name="paymentMethodId" id="paymentMethodId">
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        cardElement.on('change', (event) => {
            const displayError = document.getElementById('card-errors');
            displayError.textContent = event.error ? event.error.message : '';
        });

        const form = document.getElementById('metodo-de-pago-form');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
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
        });
    });
</script>
@endsection
