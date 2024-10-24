@extends('layouts.app')

@section('content')
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
                                    <td>
                                        <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-info btn-sm" title="Ver detalles del producto">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                        <!-- Agrega botones de editar y eliminar si es necesario -->
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
        </div>
    </div>
</div>
@endsection
