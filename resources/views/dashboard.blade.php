@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="custom-menu {{ request()->is('productos/create') || request()->is('productos/*/edit') || request()->is('productos/*') ? 'd-none' : '' }}">
            @include('partials.menu-lateral') <!-- Menú lateral -->
        </div> 
        <!-- Contenido -->
        <div class="col">
            <!-- Contenedor con imágenes y texto -->
            <h2 class="mb-4" class="text-center display-4">¡Bienvenido, {{ Auth::user()->name }}!</h2>
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
            <!-- Mensaje de éxito o error -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <!-- Mostrar sección de productos solo si es vendedor -->            
            @if (Auth::user()->is_vendedor)
                <!-- Tabla de productos -->
                @if(isset($productos) && $productos->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->id }}</td>
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
                <p>Aún no tienes productos publicados. Si deseas empezar a vender, ¡publica tu primer producto!</p>
            @endif
        </div>
    </div>
</div>
@endsection
