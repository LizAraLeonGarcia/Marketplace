@extends('layouts.app')

@section('content')
<style>
    .col-md-9, .col-lg-10 {
        padding: 0; /* Elimina el padding para evitar espacios innecesarios */
        min-height: 100vh; /* Asegúrate de que el área principal ocupe toda la altura */
        margin-left: 230px; /* Asegúrate de que el área principal comience después del menú */
        background-color: #c1c6ca; /* Color de fondo del body */
    }
    /* ------------------------------------------------------------------------------------------------------------------------------ select */
    /* Asegurar que el dropdown no afecte el alineamiento de otras opciones */
    .nav-item.dropdown {
        margin-top: 7.5px; /* Agregar un pequeño margen superior si es necesario */
    }

    .nav-item .form-control {
        width: auto; /* Asegurar que el select tenga un ancho adecuado */
        margin: 0; /* Eliminar márgenes que puedan desalinear el select */
    }
    
    .form-control {
        background-color: black; /* Fondo negro */
        color: white; /* Texto blanco */
        border: none; /* Quita el borde por defecto */
        text-align: center; /* Centra el texto de las opciones */
    }
    /* opciones dentro del select */
    .form-control option {
        background-color: black; /* Fondo negro */
        color: white; /* Texto blanco */
        text-align: center; /* Alinea el texto en el centro */
    }
    /* mejora visual al abrir el dropdown */
    .form-control:focus {
        outline: none; /* Elimina el borde de enfoque */
        box-shadow: 0px 0px 4px #c1c6ca; /* Sutil sombra alrededor */
    }
    /* ------------------------------------------------------------------------------------------------------------------- barra de búsqueda */
    .form-control[type="text"] {
        background-color: white;
        color: black; /* Puedes cambiar el color del texto si es necesario */
        border: 1px solid #ccc; /* Puedes poner un borde sutil si lo deseas */
        padding-left: 10px; /* Ajusta el padding si es necesario */
    }

    .form-control[type="text"]:focus {
        background-color: white; /* Asegúrate de que el fondo siga siendo transparente cuando está enfocado */
        box-shadow: none; /* Elimina el efecto de sombra al enfocarse, si lo hay */
    }
    /* ------------------------------------------------------------------------------------------------------------------------------ buscar */
    .btn-buscar {
        background-color: black !important; /* Color de fondo */
        color: white;
        border-radius: 0.25rem; /* Bordes redondeados */
        margin-left: 10px;
    }

    .btn-buscar:hover {
        background-color: black !important; /* Color de fondo al pasar el ratón */
        color: #c1c6ca !important;
    }
    /* --------------------------------------------------------------------------------------------------------------------------------- ver */
    .btn-secondary {
        background-color: sienna !important; /* Cambia a tu color deseado */
        border-color: sienna !important; /* Cambia el color del borde si es necesario */
    }

    .btn-secondary:hover {
        background-color: peru !important; /* Color al pasar el mouse */
        border-color: peru !important; /* Color del borde al pasar el mouse */
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
    /* --------------------------------------------------------------- tabla --------------------------------------------------------------- */
    .table th {
        text-align: center; /* centrando el texto de los encabezados de la tabla */
    }
    .table td {
        text-align: center;  /* centrando el texto de los campos de la tabla */
    }
    /* ---------------------------------------------------------------------------------------------------------- imagen previa del producto */
    .producto-img {
        width: 80px; /* Ancho deseado */
        height: 100px; /* Alto deseado */
        object-fit: cover; /* Ajusta la imagen sin distorsionar */
        border-radius: 5px; /* Bordes redondeados para darle un toque estético */
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
                <img src="{{ asset('img/menuProductos1.png') }}" alt="Imagen Izquierda" class="img-fluid" style="max-width: 180px; height: auto;">
                <!-- Navegación específica de productos -->
                <nav>
                    <ul class="nav nav-pills mb-4">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('productos.index') }}">Todos los Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos.nuevos') }}">Nuevos productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos.recomendaciones') }}">Recomendaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos.ofertas') }}">Ofertas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos.mas-vendidos') }}">Más vendidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos.precio') }}">Por precio</a>
                        </li>
                        <li class="nav-item dropdown">
                            <form method="GET" action="{{ route('productos.index') }}" class="mb-4">
                                <div class="form-group">
                                    <select name="categoria_id" id="categoria_id" class="form-control" onchange="this.form.submit()">
                                        <option value="">Todas las categorías</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </li>
                    </ul>
                    <div class="mb-4">
                        <form action="{{ route('productos.buscar') }}" method="GET" class="d-flex">
                            <input type="text" name="query" class="form-control me-2" placeholder="Buscar producto" aria-label="Buscar">
                            <button type="submit" class="btn btn-buscar"><strong>Buscar</strong></button>
                        </form>
                    </div>
                </nav>
                <!-- Imagen derecha -->
                <img src="{{ asset('img/menuProductos2.png') }}" alt="Imagen Derecha" class="img-fluid" style="max-width: 210px; height: auto;">
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
                                <th scope="col">Vista previa</th>
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
                                    <td>
                                        <!-- Muestra la primera imagen del producto -->
                                        @if($producto->images->first())
                                            <img src="{{ $producto->images->first()->url }}" alt="{{ $producto->nombre }}" class="producto-img">
                                        @else
                                            <img src="{{ asset('assets/img/placeholder.png') }}" alt="Sin imagen" class="producto-img">
                                        @endif
                                    </td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->descripcion }}</td>
                                    <td>${{ number_format($producto->precio, 2) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-secondary btn-sm" title="Ver detalles del producto">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                        <div class="button-container d-flex justify-content-center mt-2">
                                            @if (Auth::user()->can('update', $producto))
                                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-primary btn-sm mx-1"> <i class="fas fa-edit"></i> Editar Producto</a>
                                            @endif

                                            @if (Auth::user()->can('delete', $producto))
                                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');"><i class="fas fa-trash-alt"></i>Eliminar Producto</button>
                                                </form>
                                            @endif
                                        </div>
                                        <!-- Aquí verifica si el usuario autenticado es el vendedor del producto -->
                                        @if (Auth::check() && Auth::id() !== $producto->user_id)
                                            <!-- Mostrar el botón para agregar al carrito solo si el usuario no es el vendedor -->
                                                <form action="{{ route('carrito.agregar', ['producto' => $producto]) }}" method="POST">
                                                @csrf
                                                <input type="number" name="cantidad" value="1" min="1" required>
                                                <button type="submit" class="btn btn-carrito btn-sm mx-1"> <i class="fas fa-shopping-cart"></i> Agregar al carrito</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    {{ $productos->links() }} <!-- Paginación -->
                </div>
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
