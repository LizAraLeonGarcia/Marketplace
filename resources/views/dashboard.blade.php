@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 custom-menu">
            <div class="list-group custom-menu border rounded shadow-sm">
                <h5 class="list-group-item list-group-item-action active" aria-current="true">
                    Menú
                </h5>
                <a href="{{ route('productos.create') }}" class="list-group-item list-group-item-action">Crear Producto</a>
                <a href="{{ route('productos.index') }}" class="list-group-item list-group-item-action">Ver Productos</a>
                <a href="{{ route('logout') }}" class="btn btn-link-danger" title="Cerrar sesión" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                <!--<div class="list-group-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link-danger">Cerrar Sesión</button>
                    </form>
                </div>-->
                <div class="sidebar-header">
                    <img src="{{ asset('assets/img/menuLateralDashboard.png') }}" alt="Descripción de la imagen" class="img-fluid">
                </div>
            </div>
        </div>
        <!-- Área principal del dashboard -->
        <div class="col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="d-flex align-items-center mb-4 ">
                <img src="{{ asset('assets/img/dashboard.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 180px; height: auto;"> <!-- Ajusta el tamaño -->
                <div>
                    <h1>¡Bienvenido, {{ Auth::user()->name }}!</h1> <!-- Mensaje de bienvenida -->
                    <h1>A continuación, verás tus productos</h1> <!-- Los productos del usuario-->
                </div>
                <img src="{{ asset('assets/img/dashboard2.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 180px; height: auto;"> <!-- Ajusta el tamaño -->
            </div> 
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
                                <!--<a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">Eliminar</button>
                                </form>-->
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
