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
