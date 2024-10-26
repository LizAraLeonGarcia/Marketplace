@extends('layouts.app')

@section('title', 'Detalles del Producto')

@section('content')
<style>
    /* Aseguramos que html y body ocupen toda la pantalla y no tengan márgenes */
    body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        overflow: hidden; /* Elimina cualquier barra de desplazamiento */
        font-family: 'Times New Roman', Times, serif;
    }
    /* Contenedor principal ocupando toda la pantalla */
    .main-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-image: url('{{ asset('img/fondoShow.jpg') }}');
        background-size: cover;
        background-position: center;
        padding: 20px;
        box-sizing: border-box; /* Asegura que el padding no reduzca el tamaño del contenedor */
    }
    /* Contenedor del formulario ajustado para centrarse */
    .form-container {
        padding: 40px;
        border-radius: 15px;
        background: none; /* Elimina el fondo del formulario */
        width: 100%;
        max-width: 500px;
        max-height: 100vh; /* Abarca todo el alto de la pantalla */
        box-sizing: border-box;
        overflow-y: auto; /* Permite desplazarse si el contenido excede la altura */
        display: flex;
        flex-direction: column; /* Coloca los elementos en columna */
        align-items: center; /* Centra los elementos horizontalmente */
    }
    
    .product-image {
        max-width: 100%;
        height: auto;
    }
    /* Ajuste del texto y botones en el cuerpo del formulario */
    .card-header {
        background: none;
        color: black;
        text-align: center;
    }
    /* ------------------------------------------------------------------------------------------------- Estilos para el carrusel de imágenes */
    /* Ajustes para el carrusel */
    .carousel-inner {
        max-height: 400px; /* Limita la altura máxima del carrusel según sea necesario */
        margin-bottom: 20px; /* Agrega un margen inferior para separar el carrusel del texto siguiente */
    }

    .carousel-item img {
        width: 100%; /* Asegura que las imágenes ocupen el ancho completo del contenedor */
        height: auto; /* Mantiene la proporción de la imagen */
        max-height: 100%; /* Limita la altura máxima de las imágenes al 100% del contenedor */
        object-fit: cover; /* Asegura que la imagen cubra el contenedor sin distorsionarse */
    }

    /* Ajustes para los botones de control del carrusel */
    .carousel-control-prev,
    .carousel-control-next {
        width: 50px;
        height: 50px;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
        border-radius: 50%; /* Botones redondos */
        border-radius: 50%; /* Botones redondos */
        margin-left: 15px; /* Ajusta este valor para el espaciado lateral */
        margin-right: 15px; /* Ajusta este valor para el espaciado lateral */
    }
    /* Iconos de flechas en los botones */
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 20px;
        height: 20px;
        background-size: 100%;
    }
    /* Espaciado y ajuste visual de los botones de navegación */
    .carousel-control-prev {
        left: -60px; /* Se mueve un poco hacia la izquierda */
    }
    .carousel-control-next {
        right: -60px; /* Se mueve un poco hacia la derecha */
    }
    /* ------------------------------------------------------------------------------------------------- Estilos para las imágenes laterales */
    .side-image {
        position: fixed; /* Fija las imágenes en la pantalla */
        top: 50%;
        transform: translateY(-50%); /* Centra verticalmente las imágenes */
        width: 180px; /* Ajusta el tamaño según sea necesario */
        height: auto; /* Mantiene la proporción */
        z-index: 10; /* Asegura que estén por encima del contenido */
    }
    /* Posiciona la imagen a la izquierda */
    .left-image {
        left: 10px; 
    }
    /* Posiciona la imagen a la derecha */
    .right-image {
        right: 10px; 
    }
    /* ------------------------------------------------------------------------------------------------------------------------------ Botones */
    .button-container {
        display: flex;
        justify-content: space-between; 
        gap: 10px; /* Espaciado entre los botones */
        margin-bottom: 20px; 
    }
</style>

<div class="main-container">
    <!-- Imágenes laterales fijas -->
    <img src="{{ asset('img/show1.png') }}" class="side-image left-image" alt="Imagen lateral izquierda">
    <img src="{{ asset('img/show2.png') }}" class="side-image right-image" alt="Imagen lateral derecha">
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

            @if($producto->imagenes->isNotEmpty())
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
                    </a>
                </div>
            @else
                <p>No hay imágenes disponibles para este producto.</p>
            @endif

            <div class="button-container d-flex justify-content-between">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Volver al Dashboard</a>

                @if (Auth::user()->can('update', $producto))
                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-primary">Editar Producto</a>
                @endif

                @if (Auth::user()->can('delete', $producto))
                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar Producto</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
