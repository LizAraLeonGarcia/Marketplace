@extends('layouts.app')

@section('title', 'Ayuda')

@section('content')
<section id="soporte" class="soporte">
    <div class="row">
        <!-- Menú lateral -->
            @include('partials.menu-lateral') <!-- Incluye el menú lateral aquí -->
<!-- -->
        <h1 class="display-7 font-weight-bold">Si necesitas ayuda técnica, ¡contáctanos!</h1>
        <!-- Columna para la imagen -->
        <div class="col-md-6">
            <img src="{{ asset('img/soporte.png') }}" alt="Ilustración de soporte" style="max-width: 80%; height: auto;">
        </div>
        <!-- Columna para el texto -->
        <div class="col-md-6">
            <p class="justicado3">Aquí tienes todas las formas en que puedes ponerte en contacto con nosotros para solicitar soporte técnico.</p>
            <ol>
                <li>
                    <i class="fas fa-envelope"></i> Correo: 
                    <a href="mailto:vaquitamarketplace@gmail.com"> vaquitamarketplace@gmail.com</a>
                </li>
                <li>
                    <i class="fab fa-facebook-f" style="margin-right: 10px;"></i> Facebook: 
                    <a href="https://www.facebook.com/VaquitaMarketplace" target="_blank"> Vaquita Marketplace</a>
                </li>
                <li>
                    <i class="fab fa-whatsapp" style="margin-right: 10px;"></i> WhatsApp: 
                    <a href="https://wa.me/523323242223" target="_blank"> +52 1 33 2324 2223</a>
                </li>
                <li>
                    <i class="fab fa-twitter" style="margin-right: 10px;"></i> Twitter / X: 
                    <a href="https://twitter.com/VaquitaMarketplace" target="_blank"> Vaquita Marketplace</a>
                </li>
                <li>
                    <i class="fab fa-instagram" style="margin-right: 10px;"></i> Instagram: 
                    <a href="https://www.instagram.com/VaquitaMarketplace" target="_blank"> Vaquita Marketplace</a>
                </li>
            </ol>
            <div class="mt-5">
                <h5>¡No tardaremos en ayudarte!, por favor, ¡sé paciente!</h5>
            </div>
        </div>
    </div>
</section>
@endsection
