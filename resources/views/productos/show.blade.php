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
        justify-content: center; /* Centramos el contenido principal */
        align-items: flex-end; /* Alineamos al final del contenedor */
        min-height: 100vh;
        padding: 20px;
        position: relative;
    }

    /* Contenedor del formulario */
    .form-container {
        padding: 40px;
        border-radius: 15px; 
        background: rgba(255, 255, 255, 0);
        width: 600px;
        margin-bottom: 20px;
    }

    h1 {
        text-align: center;
        color: white;
    }

    .form-group {
        margin-bottom: 20px;
    }

    img {
        max-width: 100%;
        height: auto;
    }

    .product-image {
        max-width: 300px;
        height: auto;
        border-radius: 10px;
        margin: auto;
    }

    .d-flex {
        margin-top: 20px;
    }

    /* Estilo para el encabezado del producto */
    .card-header {
        background-color: none; 
        color: white;
        text-align: center;
    }

    /* Contenedor de las imágenes laterales */
    .side-images {
        display: flex;
        justify-content: space-between;
        width: 100%;
        max-width: 1200px;
        margin: auto;
    }

    .side-image {
        width: 200px;
        height: auto;
        border-radius: 10px;
        margin-bottom: 20px; /* Un pequeño espacio en la parte inferior */
        align-self: flex-end; /* Asegura que la imagen esté alineada al final del contenedor */
    }

    .image-wrapper {
        display: flex;
        justify-content: center;
        flex-direction: column; /* Alineamos verticalmente */
    }

    .card {
        border: none; /* Elimina el borde de la tarjeta */
        margin: 0; /* Elimina el margen */
        border-radius: 0; /* Opcional: eliminar el redondeo */
    }
</style>

<div class="main-container">
    <!-- Imagen lateral izquierda -->
    <div class="image-wrapper">
        <img src="{{ asset('img/show1.png') }}" alt="Imagen 1" class="side-image">
    </div>

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

            <div class="text-center mb-4">
                @if($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="img-fluid rounded product-image">
                @else
                    <p class="text-warning">No hay imagen disponible para este producto.</p>
                @endif
            </div>

            <div class="d-flex justify-content-between">
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

    <!-- Imagen lateral derecha -->
    <div class="image-wrapper">
        <img src="{{ asset('img/show2.png') }}" alt="Imagen 2" class="side-image">
    </div>
</div>
@endsection
