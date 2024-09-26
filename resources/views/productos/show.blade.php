@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalles del Producto</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $producto->nombre }}</h5>
                <p class="card-text">{{ $producto->descripcion }}</p>
                <p class="card-text"><strong>Precio:</strong> ${{ $producto->precio }}</p>
                <p class="card-text"><strong>Cantidad:</strong> {{ $producto->cantidad }}</p>
            </div>
        </div>

        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver al listado</a>
    </div>
@endsection