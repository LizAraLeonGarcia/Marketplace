@extends('layouts.app')

@section('title', 'Detalles del Producto')

@section('content')
<style>
    body {
        margin: 0;
        min-height: 100vh;
        background-image: url('{{ asset('img/fondoShow.jpg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
        font-family: 'Times New Roman', Times, serif;
    }

    .main-container {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        min-height: 100vh;
        padding: 20px;
    }

    .form-container {
        padding: 40px;
        border-radius: 15px; 
        background: rgba(255, 255, 255, 0.8);
        width: 600px;
    }

    .card-header {
        background: none; 
        color: white;
        text-align: center;
    }

    .side-image {
        width: 200px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .product-image {
        max-width: 100%;
        height: auto;
    }
</style>

<div class="main-container">
    <!-- Contenedor del formulario -->
    <div class="card shadow-lg border-light form-container">
        <div class="card-header text-center">
            <h3>{{ $producto->nombre }}</h3>
        </div>
        <div class="card-body">
            <h5 class="text-muted">ID: {{ $producto->id }}</h5>
            <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
            <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
            <p><strong>Cantidad:</strong> {{ $producto->stock }}</p>
            <p><strong>Categoría:</strong> {{ $producto->categoria->nombre }}</p>

            <div id="carouselExample" class="carousel slide mb-4" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($producto->imagenes as $key => $imagen)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $imagen->path) }}" class="d-block w-100" alt="Imagen de {{ $producto->nombre }}">
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Volver al Dashboard</a>
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
