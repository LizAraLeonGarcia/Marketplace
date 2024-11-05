@extends('layouts.app')

@section('content')
<style>
    .col-md-9, .col-lg-10 {
        padding: 0;
        min-height: 100vh;
        margin-left: 230px;
        background-color: #c1c6ca;
    }

    .btn-pagar {
        background-color: green !important;
        color: white !important;
        align-items: center;
    }
    .btn-basura {
        background-color: red !important;
        color: white !important;
    }
    .btn-detalles {
        background-color: blue !important;
        color: white !important;
    }
    .acciones {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-check-input {
        margin-right: 10px;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .total {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-top: 20px;
        text-align: end;
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
                <img src="{{ asset('assets/img/carrito1.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 150px; height: auto;">
                @if ($carritos->isNotEmpty())
                    <h2 class="mb-4">A continuación, verás tus productos para comprar.</h2>
                @else
                    <h2 class="mb-4">No tienes productos por comprar.</h2>
                @endif
                <img src="{{ asset('assets/img/carrito2.png') }}" alt="Ilustración" class="img-fluid me-3" style="width: 150px; height: auto;">
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
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
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
                                <td>{{ $producto->nombre }}</td>
                                <td>${{ number_format($producto->precio, 2) }}</td>
                                <td>
                                    <input type="number" min="1" max="{{ $producto->stock }}" name="cantidad_{{ $producto->id }}" value="{{ $producto->pivot->cantidad }}" class="form-control" />
                                </td>
                                <td>${{ number_format($subtotal, 2) }}</td>
                                <td class="acciones">
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
