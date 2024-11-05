@extends('layouts.app')

@section('content')
<style>
    .col-md-9, .col-lg-10 {
        padding: 0;
        min-height: 100vh;
        margin-left: 230px;
        background-color: #c1c6ca;
    }
    
    .form-check-input {
        margin-right: 10px;
    }
    /* Centrando el texto de los encabezados de la tabla */
    .table th {
        text-align: center;
    }
    .table td {
        text-align: center;
    }
    .producto-img {
        width: 80px; /* Ancho deseado */
        height: 100px; /* Alto deseado */
        object-fit: cover; /* Ajusta la imagen sin distorsionar */
        border-radius: 5px; /* Bordes redondeados para darle un toque estético */
    }
    /* ---------------------------------------------------------------------------------------------------------------- checkboxes al centro */
    .table td:first-child {
        text-align: center;
    }
    /* ------------------------------------------------------------------------------------------------------- alinea los inputs de cantidad */
    .table td .form-control {
        width: 80px; /* Ajusta el ancho del input */
        text-align: center;
        margin: auto;
    }
    /* ----------------------------------------------------------- para el total ----------------------------------------------------------- */
    .total {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-top: 20px;
        text-align: end;
    }
    /* -------------------------------------------------------------- botones -------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------------------------- pagar */
        .btn-pagar {
        background-color: green !important;
        color: white !important;
        align-items: center;
    }
    /* ---------------------------------------------------------------------------------------------------------------------------- eliminar */
    .btn-basura {
        background-color: red !important;
        color: white !important;
    }
    /* ------------------------------------------------------------------------------------------------------- ver los detalles del producto */
    .btn-detalles {
        background-color: blue !important;
        color: white !important;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="custom-menu {{ request()->is('productos/create') || request()->is('productos/*/edit') || request()->is('productos/*') ? 'd-none' : '' }}">
            @include('partials.menu-lateral')
        </div> 
        <div class="col">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <h2 class="mb-4 text-center display-4">Carrito de compras</h2>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <img src="{{ asset('assets/img/carrito1.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 170px; height: auto;">
                @if ($carritos->isNotEmpty())
                    <h2 class="mb-4">A continuación, verás tus productos a comprar.</h2>
                @else
                    <h2 class="mb-4">No tienes productos por comprar.</h2>
                @endif
                <img src="{{ asset('assets/img/carrito2.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 170px; height: auto;">
            </div>

            @if($carritos->isEmpty())
                <h2>¡Agrega algún producto a tu carrito para comprarlo!</h2>
            @else
                <form action="{{ route('carrito.eliminarSeleccionados') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    @php $total = 0; @endphp <!-- Variable para almacenar el total -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Seleccionar</th>
                                <th>Vista previa</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($carritos as $producto)
                            @php 
                                $subtotal = $producto->precio * $producto->pivot->cantidad;
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="productos_seleccionados[]" value="{{ $producto->id }}" class="form-check-input">
                                </td>
                                <td>
                                    <!-- Muestra la primera imagen del producto -->
                                    @if($producto->images->first())
                                        <img src="{{ $producto->images->first()->url }}" alt="{{ $producto->nombre }}" class="producto-img">
                                    @else
                                        <img src="{{ asset('assets/img/placeholder.png') }}" alt="Sin imagen" class="producto-img">
                                    @endif
                                </td>
                                <td>{{ $producto->nombre }}</td>
                                <td>${{ number_format($producto->precio, 2) }}</td>
                                <td>
                                    <input type="number" min="1" max="{{ $producto->stock }}" name="cantidad_{{ $producto->id }}" value="{{ $producto->pivot->cantidad }}" class="form-control" />
                                </td>
                                <td>${{ number_format($subtotal, 2) }}</td>
                                <td>
                                    <a href="{{ route('productos.show', $producto) }}" class="btn btn-detalles btn-sm">Ver Detalles</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!-- Mostrar el total -->
                    <div class="total">Total: ${{ number_format($total, 2) }}</div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-basura btn-sm">Eliminar seleccionados</button>
                        <button type="button" class="btn btn-pagar btn-sm">Pagar</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
