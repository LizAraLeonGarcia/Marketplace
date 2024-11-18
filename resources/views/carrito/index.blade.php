@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="custom-menu">
            @include('partials.menu-lateral')
        </div> 
        <div class="contenidoPrincipal">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <h2 class="text-center display-4 mb-4">Carrito de compras</h2>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <img src="{{ asset('assets/img/carrito1.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 170px; height: auto;">
                @if ($carritos->isNotEmpty())
                    <h2>A continuación, verás tus productos a comprar.</h2>
                @else
                    <h2>No tienes productos por comprar.</h2>
                @endif
                <img src="{{ asset('assets/img/carrito2.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 170px; height: auto;">
            </div>
            @if($carritos->isEmpty())
                <h2>¡Agrega algún producto a tu carrito para comprarlo!</h2>
            @else
                @if(auth()->check())        
                    <!-- Muestra la lista de productos en el carrito aquí -->
                    <div class="productos-grid">
                        @foreach ($carritos as $producto)
                            <div class="producto-card">
                                <div class="imagen-producto">
                                    <!-- Mostrar la primera imagen del producto o un placeholder -->
                                    @if($producto->images->first())
                                        <img src="{{ $producto->images->first()->url }}" alt="{{ $producto->nombre }}" class="producto-img">
                                    @else
                                        <img src="{{ asset('assets/img/placeholder.png') }}" alt="Sin imagen" class="producto-img">
                                    @endif
                                </div>
                                <h5 class="nombre-producto">{{ $producto->nombre }}</h5>
                                <p class="precio-producto">${{ number_format($producto->precio, 2) }}</p>
                                <div class="acciones">
                                    <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-verProductIndex btn-sm" title="Ver detalles del producto">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <!-- Botón para eliminar producto del carrito -->
                                    <form action="{{ route('carrito.eliminar', ['producto' => $producto->id]) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-eliminarProductIndex btn-sm mx-1" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto del carrito?');">
                                            <i class="fas fa-trash-alt"></i> Quitar del carrito
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <h1 class="text-center">Por favor, inicia sesión para ver los productos en tu carrito.</h1>
                @endif
            @endif
        </div>
    </div>

</div>
@endsection
