@extends('layouts.app')

@section('title', 'Ayuda')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="custom-menu {{ request()->is('productos/create') || request()->is('productos/*/edit') || request()->is('productos/*') ? 'd-none' : '' }}">
            @include('partials.menu-lateral') <!-- Menú lateral -->
        </div>
        <!-- Contenido -->
        <div class="col">
            <section id="soporte" class="soporte">
                <h2 class="mb-4" class="text-center display-4">¿Algún problema?</h1>
                <p class="justificado">No te preocupes, a continuación tendrás una sección de preguntas y respuestas, quizás la solución a tu inconveniente esté ahí.</p>
                <!-- Carrousel de preguntas y respuestas -->
                <div id="faqCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner text-center">
                        <div class="carousel-item">
                            <h5>¿Cómo edito mi cuenta?</h5>
                            <p>Puedes editar tu cuenta yendo a la opción Mi cuenta en el menú lateral de tu Dashboard, ahí encontrarás la opción Editar cuenta, donde puedes editar tu nombre, apellido, apodo, descripción, sexo, país, correo, contraseña y foto.</p>
                        </div>
                        <div class="carousel-item">
                            <h5>¿Cómo edito mi perfil de comprador?</h5>
                            <p>Respuesta a la pregunta 3.</p>
                        </div>
                        <div class="carousel-item">
                            <h5>¿Cómo edito mi perfil de vendedor?</h5>
                            <p>Respuesta a la pregunta 3.</p>
                        </div>
                        <div class="carousel-item active">
                            <h5>¿Cómo creó un producto?</h5>
                            <p>Puedes crearlo directamente en la opción Crear producto que aparece en el menú lateral de tu Dashboard.</p>
                        </div>
                        <div class="carousel-item">
                            <h5>¿Cómo edito un producto?</h5>
                            <p>Respuesta a la pregunta 2.</p>
                        </div>
                        <div class="carousel-item">
                            <h5>¿Cómo veo un producto?</h5>
                            <p>Respuesta a la pregunta 3.</p>
                        </div>
                        <div class="carousel-item">
                            <h5>¿Cómo elimino un producto?</h5>
                            <p>Respuesta a la pregunta 3.</p>
                        </div>
                        <div class="carousel-item">
                            <h5>¿Cómo compro un producto?</h5>
                            <p>Respuesta a la pregunta 3.</p>
                        </div>
                        <div class="carousel-item">
                            <h5>¿Cómo veo mis reseñas como vendedor?</h5>
                            <p>Respuesta a la pregunta 3.</p>
                            </div>
                        <div class="carousel-item">
                            <h5>¿Cómo veo mis reseñas como comprador?</h5>
                            <p>Respuesta a la pregunta 3.</p>
                        </div>
                        <div class="carousel-item">
                            <h5>¿ pregunta ?</h5>
                            <p>Respuesta.</p>
                        </div>
                    </div>
                    <!-- Controles personalizados -->
                    <div class="carousel-controls">
                        <button class="btn btn-outline-primary" type="button" data-target="#faqCarousel" data-slide="prev">
                            <i class="fas fa-chevron-left"></i> Anterior
                            </button>
                        <button class="btn btn-outline-primary" type="button" data-target="#faqCarousel" data-slide="next">
                            Siguiente <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="row mt-4 -no-gutters"> 
                    <div class="col-md-6">
                        <p class="justificado">¿Tu problema no se resolvió en la sección anterior? ¡Contáctanos! Abajo tendrás todas las formas en que puedes comunicarte con nosotros para hacernos llegar tus dudas.</p>
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
                    </div>
                    <div class="col-md-6">
                        <img src="{{ asset('assets/img/dashboardAyuda.png') }}" alt="Ilustración de soporte" class="img-fluid">
                        <h5 class="text-center">¡No tardaremos en ayudarte!, por favor, ¡sé paciente!</h5>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
