@extends('layouts.app')

@section('title', 'Detalles del Producto')

@section('content')

    <div class="productShow">
        <img src="{{ asset('img/show1.png') }}" class="side-image left-image" alt="Imagen lateral izquierda">
        <!-- Contenedor del formulario -->
        <div class="contenidoProductShow shadow-lg border-light">
            <div class="card-header">
                <h5><strong>{{ $producto->nombre }}</strong></h5>
            </div>
            <div class="card-body">
                <p><strong>ID: {{ $producto->id }}</strong></p>
                <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
                <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
                <p><strong>Cantidad:</strong> {{ $producto->stock }}</p>
                <p><strong>Categoría:</strong> {{ $producto->categoria->nombre }}</p>

                @if($producto->images && $producto->images->isNotEmpty())
                    <div id="carouselExample" class="carousel slide mb-4" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($producto->images as $key => $imagen)
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                    <img src="{{ Storage::url($imagen->path) }}" class="d-block w-100" alt="Imagen de {{ $producto->nombre }}">
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
                @else
                    <p>No hay imágenes disponibles para este producto.</p>
                @endif

                <div class="button-container d-flex justify-content-between">
                    @if (Auth::user()->can('update', $producto))
                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-editProductShow">Editar Producto</a>
                    @endif

                    @if (Auth::user()->can('delete', $producto))
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-deleteProductShow" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar Producto</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <img src="{{ asset('img/show2.png') }}" class="side-image right-image" alt="Imagen lateral derecha">
    </div>
@endsection
