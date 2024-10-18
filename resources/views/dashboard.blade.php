@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2">
            <div class="list-group custom-menu border rounded shadow-sm">
                <h5 class="list-group-item list-group-item-action active" aria-current="true">
                    Menú
                </h5>
                <a href="{{ route('productos.create') }}" class="list-group-item list-group-item-action">Crear Producto</a>
                <a href="{{ route('productos.index') }}" class="list-group-item list-group-item-action">Ver Productos</a>
                <div class="list-group-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Área principal del dashboard -->
        <div class="col-md-9 col-lg-10">
            <h1>¡Bienvenido, {{ Auth::user()->name }}!</h1> <!-- Mensaje de bienvenida -->
            <h1>Mis productos</h1>
            <!-- Mensaje de éxito o error -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <!-- Tabla de productos -->
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
                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $productos->links() }} <!-- Paginación -->
        </div>
    </div>
</div>
@endsection
