@extends('layouts.app')

@section('content')
<div class="container-fluid"> 
    <div class="row">
        <!-- Menú lateral -->
        <div class="custom-menu {{ request()->is('productos/create') || request()->is('productos/*/edit') || request()->is('productos/*') ? 'd-none' : '' }}">
            @include('partials.menu-lateral')
        </div>
        <!-- Contenido -->
        <div class="col">
            <h2 class="mb-4" class="text-center display-4">Perfil como Vendedor</h2>
            
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

            <h3>Estadísticas de ventas</h3>
            <!-- Aquí puedes agregar gráficos o tablas con estadísticas -->
            <h3>Mis reseñas como vendedor</h3>
        </div>
    </div>
</div>
@endsection
