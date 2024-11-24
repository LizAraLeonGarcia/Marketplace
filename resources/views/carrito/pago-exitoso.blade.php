@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Menú lateral -->
    <div class="custom-menu">
        @include('partials.menu-lateral')
    </div>
    <!-- Contenido -->
    <div class="contenidoPrincipal">
        <div class="alert alert-success">
            <p class="compra-titulo">¡Gracias por tu compra!</p>
            <p class="compra-detalle">Tu pedido ha sido procesado correctamente.</p>
        </div>
        <div class="mt-4">
            <img src="{{ asset('assets/img/pagoExitoso.png') }}" alt="Pago exitoso" class="imgPagoExitoso" style="max-width: 400px;">
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        var duration = 15 * 1000; // Duración del confeti
        var end = Date.now() + duration;
        var colors = ['#ff0000', '#00ff00', '#0000ff']; // Colores del confeti

        (function frame() {
            confetti({
                particleCount: 5,
                angle: 60,
                spread: 55,
                origin: { x: 0 },
                colors: colors
            });
            confetti({
                particleCount: 5,
                angle: 120,
                spread: 55,
                origin: { x: 1 },
                colors: colors
            });

            if (Date.now() < end) {
                requestAnimationFrame(frame);
            }
        })();
    };
</script>
@endsection
