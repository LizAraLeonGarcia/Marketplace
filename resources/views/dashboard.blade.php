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
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="fas fa-user me-2"></i> Mi cuenta
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="fas fa-store me-2"></i> Ver mi perfil como vendedor
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="fas fa-shopping-bag me-2"></i> Ver mi perfil como comprador
                </a>
                <a href="{{ route('productos.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="fas fa-plus-circle me-2"></i> Crear producto
                </a>
                <a href="{{ route('productos.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="fas fa-box-open me-2"></i> Ver productos
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="fas fa-shopping-cart me-2"></i> Carrito
                </a>
                <a href="{{ route('ayuda.contacto') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="fas fa-headset me-2"></i> Ayuda
                </a>
                <div class="sidebar-header">
                    <img src="{{ asset('assets/img/menuLateralDashboard.png') }}" alt="Descripción de la imagen" class="img-fluid">
                </div>
                <a href="#" class="list-group-item list-group-item-action"></a>
                <a href="{{ route('logout') }}" class="btn btn-link-danger" title="Cerrar sesión" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        
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
        </div>
    </div>
</div>
@endsection
