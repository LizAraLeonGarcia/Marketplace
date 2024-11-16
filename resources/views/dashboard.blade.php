@extends('layouts.app')

@section('title', 'Vaquita Marketplace')

@section('content')

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
        <div class="custom-menu">
            @include('partials.menu-lateral') <!-- Menú lateral -->
        </div> 
        <!-- Contenido -->
        <div class="contenidoPrincipal">
            <h2 class="mb-4" class="text-center display-4">¡Hola, {{ Auth::user()->name }}!</h2>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <!-- Imagen izquierda -->
                <img src="{{ asset('assets/img/dashboard2.png') }}" alt="Ilustración" class="img-fluid">
                @if (Auth::user()->is_vendedor)
                    <h2 class="mb-4">A continuación, verás tus productos publicados como vendedor.</h2>
                @else
                    <h2 class="mb-4">No tienes productos publicados como vendedor.</h2>
                @endif
                <!-- Imagen derecha -->
                <img src="{{ asset('assets/img/dashboard.png') }}" alt="Ilustración" class="img-fluid">
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
                    
                @else
                    <p>No hay productos publicados.</p>
                @endif
            @else
                <!-- Mostrar mensaje si no es vendedor -->
                <h2>Si deseas empezar a vender, ¡crea tu primer producto!</h2>
            @endif
        </div>
        <!-- Paginación -->
        <div class="pagination">
            {{ $productos->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
