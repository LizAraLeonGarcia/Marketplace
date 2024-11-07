@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .col-md-9, .col-lg-10 {
        padding: 0; /* Elimina el padding para evitar espacios innecesarios */
        min-height: 100vh; /* Asegúrate de que el área principal ocupe toda la altura */
        margin-left: 230px; /* Asegúrate de que el área principal comience después del menú */
        background-color: #c1c6ca; /* Color de fondo del body */
    }
    /* Centrando el texto de los encabezados de la tabla */
    .table th {
        text-align: center;
    }
    .table td {
        text-align: center;
    }
    /* imagen previa del producto */
    .producto-img {
        width: 80px; /* Ancho deseado */
        height: 100px; /* Alto deseado */
        object-fit: cover; /* Ajusta la imagen sin distorsionar */
        border-radius: 5px; /* Bordes redondeados para darle un toque estético */
    }
</style>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('verified'))
    <div class="alert alert-info">
        {{ __('Tu correo electrónico ha sido verificado. ¡Bienvenido!') }}
    </div>
@endif

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="custom-menu {{ request()->is('productos/create') || request()->is('productos/*/edit') || request()->is('productos/*') ? 'd-none' : '' }}">
            @include('partials.menu-lateral') <!-- Menú lateral -->
        </div> 
        <!-- Contenido -->
        <div class="col">
            <!-- Contenedor con imágenes y texto -->
            <h2 class="mb-4" class="text-center display-4">¡Hola, {{ Auth::user()->name }}!</h2>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <!-- Imagen izquierda -->
                <img src="{{ asset('assets/img/dashboard2.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 150px; height: auto;">
                @if (Auth::user()->is_vendedor)
                    <h2 class="mb-4">A continuación, verás tus productos publicados como vendedor.</h2>
                @else
                    <h2 class="mb-4">No tienes productos publicados como vendedor.</h2>
                @endif
                <!-- Imagen derecha -->
                <img src="{{ asset('assets/img/dashboard.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 150px; height: auto;">
            </div>
            <!-- Mostrar sección de productos solo si es vendedor -->            
            @if (Auth::user()->is_vendedor)
                <!-- Tabla de productos -->
                @if(isset($productos) && $productos->isNotEmpty())
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
                                        <td>{{ $producto->id }}</td>
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
                                        <td>
                                            <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-info btn-sm" title="Ver detalles del producto">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm" title="Editar producto">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar producto" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                                    <i class="fas fa-trash-alt"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $productos->links() }} <!-- Paginación -->
                @else
                    <p>No hay productos publicados.</p>
                @endif
            @else
                <!-- Mostrar mensaje si no es vendedor -->
                <h2>Si deseas empezar a vender, ¡crea tu primer producto!</h2>
            @endif
        </div>
    </div>
</div>
@endsection
