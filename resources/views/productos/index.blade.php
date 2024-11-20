@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="custom-menu">
            @include('partials.menu-lateral')
        </div>
        <!-- Contenido -->
        <div class="contenidoPrincipal">
            <h2 class="mb-4" class="text-center display-4">Estos son los productos disponibles para ti en.... ¡Vaquita Marketplace!</h2>
            <!-- Contenedor con imágenes y navegación -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <!-- Imagen izquierda -->
                <img src="{{ asset('img/menuProductos1.png') }}" alt="Imagen Izquierda" class="imagen-izquierda">
                <!-- Navegación específica de productos -->
                    <ul class="nav-productosIndex">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('productos.index') }}">
                            <i class="fas fa-th"></i>Todos los Productos</a>
                        </li>
                        <li class="nav-item dropdown contenedor-categorias">
                            <form method="GET" action="{{ route('productos.index') }}">
                                <select name="categoria_id" id="categoria_id" class="form-control" onchange="this.form.submit()">
                                    <option value="">Todas las categorías</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            <i class="fas fa-star"></i>Nuevos productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            <i class="fas fa-heart"></i> Recomendaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            <i class="fas fa-tags"></i>Ofertas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            <i class="fas fa-chart-line"></i>Más vendidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos.precio') }}">
                            <i class="fas fa-dollar-sign"></i>Por precio</a>
                        </li>
                    </ul>
                    <!-- Barra de búsqueda -->
                    <form action="{{ route('productos.buscar') }}" method="GET" class="contenedorBarraBusqueda">
                        <input type="text" name="query" class="form-buscar me-2" placeholder="Buscar producto" aria-label="Buscar">
                        <button type="submit" class="btn btn-buscarProduct"><strong>Buscar</strong></button>
                    </form>
                 <!-- Imagen derecha -->
                <img src="{{ asset('img/menuProductos2.png') }}" alt="Imagen Derecha" class="imagen-derecha">
            </div>   
             <!-- Mensajes de error y éxito -->
             @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif 
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- para la barra de busqueda -->
            @if(isset($query))
                <p class="alert alert-info">Resultados para: <strong>{{ $query }}</strong></p>
            @endif
            <!-- productos -->
            @if($productos->isEmpty())
                <p class="alert alert-warning">No se encontraron productos que coincidan con tu búsqueda.</p>
            @else       
                <!-- Muestra la lista de productos aquí -->
                <div class="productos-grid">
                    @foreach ($productos as $producto)
                        <div class="producto-card">
                            <div>
                                <!-- Muestra la primera imagen del producto -->
                                @if($producto->images->first())
                                    <img src="{{ $producto->images->first()->url }}" alt="{{ $producto->nombre }}" class="producto-img">
                                @else
                                    <img src="{{ asset('assets/img/placeholder.png') }}" alt="Sin imagen" class="producto-img">
                                @endif
                            </div>
                            <h5 class="nombre-producto">{{ $producto->nombre }}</h5>
                            <p class="precio-producto">${{ number_format($producto->precio, 2) }}</p>
                            <div class="acciones">
                                <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-verProductIndex btn-sm" title="Ver detalles del producto">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                @if (Auth::user()->can('update', $producto))
                                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-editarProductIndex btn-sm mx-1">
                                        <i class="fas fa-edit"></i> Editar Producto
                                    </a>
                                @endif
                                @if (Auth::user()->can('delete', $producto))
                                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-block botonEliminarProductoIndex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-eliminarProductIndex btn-sm mx-1" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                            <i class="fas fa-trash-alt"></i> Eliminar Producto
                                        </button>
                                    </form>
                                @endif
                                @if (Auth::check() && Auth::id() !== $producto->user_id)
                                    <form action="{{ route('carrito.agregar', ['producto' => $producto]) }}" method="POST" class="mt-2">
                                        @csrf
                                        <input type="number" name="cantidad" value="1" min="1" required>
                                        <button type="submit" class="btn btn-carrito btn-sm mx-1">
                                            <i class="fas fa-shopping-cart"></i> Agregar al carrito
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @foreach($producto->reviews as $review)
                    <p>{{ $review->review }}</p>
                    <p>Calificación: {{ $review->rating }}</p>
                    <p>Por: {{ $review->user->name }}</p>
                @endforeach
                <div class="pagination">
                    {{ $productos->links('pagination::custom') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
