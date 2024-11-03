@extends('layouts.app')

@section('content')
<style>
    .col-md-9, .col-lg-10 {
        padding: 0; /* Elimina el padding para evitar espacios innecesarios */
        min-height: 100vh; /* Asegúrate de que el área principal ocupe toda la altura */
        margin-left: 230px; /* Asegúrate de que el área principal comience después del menú */
        background-color: #c1c6ca; /* Color de fondo del body */
    }
    /* --------------------------------------------------------------------------------------------------------------------------------- ver */
    .btn-secondary {
        background-color: #ef6c00 !important; /* Cambia a tu color deseado */
        border-color: #ef6c00 !important; /* Cambia el color del borde si es necesario */
    }

    .btn-secondary:hover {
        background-color: orange !important; /* Color al pasar el mouse */
        border-color: orange !important; /* Color del borde al pasar el mouse */
    }
    /* ------------------------------------------------------------------------------------------------------------------------------ editar */
    .btn-primary {
        background-color: #1a237e; /* Cambia a tu color deseado */
        border-color: #1a237e; /* Cambia el color del borde si es necesario */
    }

    .btn-primary:hover {
        background-color: blue; /* Color al pasar el mouse */
        border-color: blue; /* Color del borde al pasar el mouse */
    }
    /* ---------------------------------------------------------------------------------------------------------------------------- eliminar */
    .btn-danger {
        background-color: #c62828 !important; /* Cambia a tu color deseado */
        border-color: #c62828 !important; /* Cambia el color del borde si es necesario */
    }

    .btn-danger:hover {
        background-color: red !important; /* Color al pasar el mouse */
        border-color: red !important; /* Color del borde al pasar el mouse */
    }
    /* ----------------------------------------------------------------------------------------------------------------------------- carrito */
    .btn-carrito {
        background-color: #1b5e20 !important; /* Cambia a tu color deseado */
        border-color: #1b5e20 !important; /* Cambia el color del borde si es necesario */
    }

    .btn-carrito:hover {
        background-color: green !important; /* Color al pasar el mouse */
        border-color: green !important; /* Color del borde al pasar el mouse */
    }
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="custom-menu {{ request()->is('productos/create') || request()->is('productos/*/edit') || request()->is('productos/*') ? 'd-none' : '' }}">
                @include('partials.menu-lateral') <!-- Menú lateral -->
        </div>
        <!-- Contenido -->
        <div class="col">
            <h2 class="mb-4" class="text-center display-4">Estos son los productos disponibles para ti en.... ¡Vaquita Marketplace!</h2>
            <!-- Contenedor con imágenes y navegación -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <!-- Imagen izquierda -->
                <img src="{{ asset('img/menuProductos1.png') }}" alt="Imagen Izquierda" class="img-fluid" style="max-width: 170px; height: auto;">
                <!-- Navegación específica de productos -->
                <nav>
                    <ul class="nav nav-pills mb-4">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('productos.index') }}">Todos los Productos</a>
                        </li>
                        @foreach($categorias as $categoria)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('productos.categoria', $categoria->id) }}">{{ $categoria->nombre }}</a>
                            </li>
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos.precio') }}">Por precio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos.mas-vendidos') }}">Más vendidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos.nuevos') }}">Nuevos productos</a>
                        </li>
                    </ul>
                </nav>
                <!-- Imagen derecha -->
                <img src="{{ asset('img/menuProductos2.png') }}" alt="Imagen Derecha" class="img-fluid" style="max-width: 200px; height: auto;">
            </div>    
            <!-- Mensaje de éxito -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Mensajes de error -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(auth()->check())        
            <!-- Muestra la lista de productos aquí -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr>
                                    <th scope="row">{{ $producto->id }}</th>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->descripcion }}</td>
                                    <td>${{ number_format($producto->precio, 2) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-secondary btn-sm" title="Ver detalles del producto">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                        <div class="button-container d-flex justify-content-center mt-2">
                                            @if (Auth::user()->can('update', $producto))
                                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-primary btn-sm mx-1">Editar Producto</a>
                                            @endif

                                            @if (Auth::user()->can('delete', $producto))
                                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar Producto</button>
                                                </form>
                                            @endif
                                        </div>
                                        <!-- Aquí verifica si el usuario autenticado es el vendedor del producto -->
                                        @if (Auth::check() && Auth::id() !== $producto->user_id)
                                            <!-- Mostrar el botón para agregar al carrito solo si el usuario no es el vendedor -->
                                                <form action="{{ route('carrito.agregar', ['producto' => $producto]) }}" method="POST">
                                                @csrf
                                                <input type="number" name="cantidad" value="1" min="1" required>
                                                <button type="submit" class="btn btn-carrito btn-sm mx-1">Agregar al carrito</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $productos->links() }} <!-- Paginación -->
            @else
                <h1 class="text-center">Por favor, inicia sesión para ver los productos.</h1>
            @endif

            @foreach($producto->reviews as $review)
                <p>{{ $review->review }}</p>
                <p>Calificación: {{ $review->rating }}</p>
                <p>Por: {{ $review->user->name }}</p>
            @endforeach
        </div>
    </div>
</div>
@endsection
