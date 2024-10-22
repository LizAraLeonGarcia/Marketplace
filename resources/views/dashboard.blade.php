@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        @include('partials.menu-lateral')
        <!-- Área principal del dashboard -->
        <div class="col-md-9 col-lg-10">
            <div class="dashboard-welcome">
                <img src="{{ asset('assets/img/dashboard.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 180px; height: auto;">
                <div>
                    <h1>¡Bienvenido, {{ Auth::user()->name }}!</h1>
                    <h2>A continuación, verás tus productos publicados.</h2>
                </div>
                <img src="{{ asset('assets/img/dashboard2.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 180px; height: auto;">
            </div>
            
            <!-- Mensaje de éxito o error -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <!-- Tabla de productos -->
            @if(isset($productos) && $productos->isNotEmpty())
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

                {{ $productos->links() }} <!-- Paginación -->
            @else
                <p>No hay productos publicados.</p>
            @endif
        </div>
    </div>
</div>
@endsection
