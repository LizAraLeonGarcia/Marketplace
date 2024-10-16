@extends('layouts.app')

@section('title', 'Detalles del Producto')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">Detalles del Producto</h2>
        <div class="card">
            <div class="card-header text-center">
                <h3>{{ $producto->nombre }}</h3>
            </div>
            <div class="card-body">
                <h5>ID: {{ $producto->id }}</h5>
                <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
                <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
                <p><strong>Cantidad:</strong> {{ $producto->stock }}</p>
                <p><strong>Categoría:</strong> {{ $producto->categoria->nombre }}</p> <!-- Mostrar la categoría -->
                <!-- Muestra la imagen del producto -->
                @if($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" width="200">
                @else
                    <p>No hay imagen disponible para este producto.</p>
                @endif

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver a la lista</a>
                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-primary">Editar Producto</a>

                    <!-- Botón para eliminar (si es apropiado) -->
                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar Producto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
