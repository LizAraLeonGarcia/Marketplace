@extends('layouts.app')

@section('title', 'Detalles del Producto')

@section('content')
    <div class="container">
        <h2 class="mb-4">Detalles del Producto</h2>

        <div class="card">
            <div class="card-header">
                <h3>{{ $producto->nombre }}</h3>
            </div>
            <div class="card-body">
                <h5>ID: {{ $producto->id }}</h5>
                <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
                <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
                <p><strong>Cantidad:</strong> {{ $producto->cantidad }}</p>
                <p><strong>Vendedor ID:</strong> {{ $producto->vendedor_id }}</p>

                @if ($producto->imagen)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="img-fluid">
                    </div>
                @endif

                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver a la lista</a>
                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-primary">Editar Producto</a>
            </div>
        </div>
    </div>
@endsection

