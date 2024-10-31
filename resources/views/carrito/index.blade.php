@extends('layouts.app')

@section('content')
<style>
    .col-md-9, .col-lg-10 {
        padding: 0; /* Elimina el padding para evitar espacios innecesarios */
        min-height: 100vh; /* Asegúrate de que el área principal ocupe toda la altura */
        margin-left: 230px; /* Asegúrate de que el área principal comience después del menú */
        background-color: #c1c6ca; /* Color de fondo del body */
    }
    /* ---------------------------------------------------------- PARA LOS BOTONES ---------------------------------------------------------- */
    .btn-pagar {
        background-color: green !important; /* Color verde para pagar */
        color: white !important;
        align-items: center;
    }
    .btn-basura {
        background-color: red !important; /* Color rojo para eliminar */
        color: white !important;
    }
    .btn-detalles {
        background-color: blue !important; /* Color azul para ver detalles */
        color: white !important;
    }
    /* Alineación de los botones */
    .acciones {
        display: flex;
        align-items: center;
        gap: 10px; /* Espacio entre los botones */
    }

    .form-check-input {
        margin-right: 10px; /* Espacio a la derecha del checkbox */
    }
</style>

<div class="container-fluid">
    <div class=row>
        <!-- Menú lateral -->
        <div class="custom-menu {{ request()->is('productos/create') || request()->is('productos/*/edit') || request()->is('productos/*') ? 'd-none' : '' }}">
            @include('partials.menu-lateral') <!-- Menú lateral -->
        </div> 
        <!-- Contenido -->
        <div class="col">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <!-- Contenedor con imágenes y texto -->
            <h2 class="mb-4" class="text-center display-4">Carrito de compras</h2>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <!-- Imagen izquierda -->
                <img src="{{ asset('assets/img/carrito1.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 150px; height: auto;">
                @if ($carritos->isNotEmpty())
                    <h2 class="mb-4">A continuación, verás tus productos para comprar.</h2>
                @else
                    <h2 class="mb-4">No tienes productos por comprar.</h2>
                @endif
                <!-- Imagen derecha -->
                <img src="{{ asset('assets/img/carrito2.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 150px; height: auto;">
            </div>

            @if($carritos->isEmpty())
                <h2>¡Agrega algún producto a tu carrito para comprarlo!</h2>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($carrito as $producto)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input" id="producto_{{ $producto->id }}">
                                </td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->pivot->cantidad }}</td>
                                <td>
                                <td>
                                    <input type="number" min="1" max="{{ $producto->pivot->cantidad }}" name="cantidad_{{ $producto->id }}" value="{{ $producto->pivot->cantidad }}" class="form-control" />
                                </td>
                                <td class="acciones">
                                    <a href="{{ route('productos.show', $producto) }}" class="btn btn-detalles btn-sm">Ver Detalles</a>
                                    <form action="{{ route('carrito.eliminar', $producto->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-basura btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-pagar btn-sm">Pagar</button>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
