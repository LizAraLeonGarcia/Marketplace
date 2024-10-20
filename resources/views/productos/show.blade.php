@extends('layouts.app')

@section('title', 'Detalles del Producto')

@section('content')
    <div class="container-fluid" style="background-image: url('{{ asset('img/fondoShow.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh;">
        <h2 class="text-center mb-4" style="font-family: 'Times New Roman', serif;">Detalles del Producto</h2>
        <div class="card shadow-lg border-light" style="font-family: 'Times New Roman', serif; background-color: rgba(255, 255, 255, 0.9);">
            <div class="card-header text-center bg-primary text-white">
                <h3>{{ $producto->nombre }}</h3>
            </div>
            <div class="card-body">
                <h5 class="text-muted">ID: {{ $producto->id }}</h5>
                <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
                <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
                <p><strong>Cantidad:</strong> {{ $producto->stock }}</p>
                <p><strong>Categoría:</strong> {{ $producto->categoria->nombre }}</p>

                <div class="text-center mb-4">
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="img-fluid rounded" style="max-width: 300px; height: auto;">
                    @else
                        <p class="text-warning">No hay imagen disponible para este producto.</p>
                    @endif
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver a la lista</a>
                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-primary">Editar Producto</a>

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
