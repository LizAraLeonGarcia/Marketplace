<!-- resources/views/layouts/navigation.blade.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Mi Marketplace</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productos.index') }}">Productos</a> <!-- Enlace a productos -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contacto">Contacto</a>
                </li>
                <!-- Otras opciones del menú principal -->
            </ul>
        </div>
    </div>
</nav>

<!-- Submenú de productos, solo visible en la página de productos -->
@if(request()->routeIs('productos.index'))
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <h4>Filtrar por</h4>
                <ul class="list-group">
                    <li class="list-group-item"><a href="#">Todos los Productos</a></li>
                    <li class="list-group-item"><a href="#">Por categoría</a></li>
                    <li class="list-group-item"><a href="#">Por precio</a></li>
                    <li class="list-group-item"><a href="#">Más vendidos</a></li>
                    <li class="list-group-item"><a href="#">Nuevos productos</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                @yield('products-content') <!-- Aquí se mostrarán los productos -->
            </div>
        </div>
    </div>
@endif
