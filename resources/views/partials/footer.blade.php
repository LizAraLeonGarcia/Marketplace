<!-- resources/views/partials/footer.blade.php -->

<footer class="bg-light text-center text-lg-start mt-5">
    <div class="container p-4">
        <div class="row">
            <!-- Sección sobre nosotros -->
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Sobre nosotros</h5>
                <p>
                    Este es un marketplace en línea donde puedes encontrar productos únicos y de calidad. Nuestro objetivo es conectar a vendedores y compradores de manera segura y eficiente.
                </p>
            </div>

            <!-- Sección de enlaces útiles -->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Enlaces útiles</h5>
                <ul class="list-unstyled mb-0">
                    <li>
                        <a href="{{ url('/') }}" class="text-dark">Inicio</a>
                    </li>
                    <li>
                        <a href="{{ route('productos.index') }}" class="text-dark">Productos</a>
                    </li>
                    <li>
                        <a href="#" class="text-dark">Política de privacidad</a>
                    </li>
                    <li>
                        <a href="#" class="text-dark">Términos y condiciones</a>
                    </li>
                </ul>
            </div>

            <!-- Sección de contacto -->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Contacto</h5>
                <ul class="list-unstyled mb-0">
                    <li>
                        <p><i class="fas fa-map-marker-alt"></i> 123 Calle Falsa, Ciudad Ficticia</p>
                    </li>
                    <li>
                        <p><i class="fas fa-envelope"></i> info@marketplace.com</p>
                    </li>
                    <li>
                        <p><i class="fas fa-phone"></i> +123 456 7890</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="text-center p-3 bg-dark text-white">
        © 2024 Copyright:
        <a class="text-white" href="{{ url('/') }}">Mi Marketplace</a>
    </div>
</footer>
