@extends('layouts.app')

@section('title', 'Lista de Productos')

@section('content')
<div class="container">
    <h2 class="mb-4">Estos son los productos disponibles para ti en.... ¡Vaquita Marketplace!</h2>
    <!-- Navegación específica de productos -->
    <nav>
        <ul class="nav nav-pills mb-4 nav-fill">
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
            <!-- Opción para ir al Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">Ir al Dashboard</a>
            </li>
        </ul>
    </nav>
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
        <!--<a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Crear Producto</a>-->
        <!-- Muestra la lista de productos aquí -->
        <table class="table table-striped table-responsive">
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
                    <tr class="table-hover">
                        <th scope="row">{{ $producto->id }}</th>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>${{ number_format($producto->precio, 2) }}</td>
                        <td>
                            <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-info btn-sm" title="Ver detalles del producto">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <!--<a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm" title="Editar producto">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar producto" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>-->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $productos->links() }} <!-- Paginación -->
    @else
        <h1>Por favor, inicia sesión para ver los productos.</h1>
    @endif
</div>
@endsection
