@extends('layouts.app')

@section('content')
<style>
    .col-md-9, .col-lg-10 {
        padding: 0; /* Elimina el padding para evitar espacios innecesarios */
        min-height: 100vh; /* Asegúrate de que el área principal ocupe toda la altura */
        margin-left: 230px; /* Asegúrate de que el área principal comience después del menú */
        background-color: #c1c6ca; /* Color de fondo del body */
    }
</style>

<div class="container"> 
    <div class="container-fluid">
        <!-- Menú lateral -->
        <div class="custom-menu {{ request()->is('productos/create') || request()->is('productos/*/edit') || request()->is('productos/*') ? 'd-none' : '' }}">
            @include('partials.menu-lateral')
        </div>
        <!-- Contenido -->
        <div class="col">
            <div class="row d-flex align-items-center mb-4">
                <div class="col-md-8">
                    <h2 class="display-4 mb-0">Perfil como Vendedor</h2>
                </div>
                <div class="col-md-4 text-md-end">
                    <img src="{{ asset('assets/img/perfilVendedor.png') }}" alt="Ilustración" class="img-fluid" style="width: 200px; height: auto;">
                </div>
            </div>
            
            <div class="col-md-8">
                <h5 class="fw-bold">ID del usuario: {{ $user->id }} </h5>
                <h5 class="fw-bold">Nombre: {{ $user->nombre }} {{ $user->apellido }}</h5>
                <p><strong>Apodo:</strong> {{ $user->apodo ?? 'No especificado' }}</p>
                <p><strong>País:</strong> {{ $user->pais }}</p>
                <p><strong>Correo:</strong> {{ $user->email }}</p>
            </div>

            <h3>Mis Productos</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre del Producto</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>{{ $producto->precio }}</td>
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
            
            <h3>Mis reseñas como vendedor</h3>
        </div>
    </div>
</div>
@endsection
