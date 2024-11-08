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
    }
    /* ---------------------------------------------------------------------------------------------------------------------------- eliminar */
    .btn-basura {
        background-color: red !important;
        color: white !important;
    }
    /* ------------------------------------------------------------------------------------------------------- ver los detalles del producto */
    .btn-detalles {
        background-color: sienna !important;
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
                <form id="carritoForm" method="POST">
                    @csrf
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
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="productos_seleccionados[]" value="{{ $producto->id }}" class="form-check-input checkbox-producto" data-subtotal="{{ $subtotal }}" onchange="actualizarTotal()">
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
                                    <input type="number" min="1" max="{{ $producto->stock }}" name="cantidad_{{ $producto->id }}" value="{{ $producto->pivot->cantidad }}" class="form-control cantidad-producto" onchange="actualizarSubtotal(this, {{ $producto->id }})" />
                                </td>
                                <td><span class="subtotal-producto">${{ number_format($subtotal, 2) }}</span></td>
                                <td>
                                    <a href="{{ route('productos.show', $producto) }}" class="btn btn-detalles btn-sm"> <i class="fas fa-eye"></i> Ver Detalles</a>
                                </td>
                            </tr>
                            @if(in_array($producto->id, old('productos_seleccionados', [])))
                                @php $total += $subtotal; @endphp
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    <!-- Mostrar el total con ID -->
                    <div class="total">Total: $<span id="total">{{ number_format($total, 2) }}</span></div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-basura btn-sm" onclick="setAction('{{ route('carrito.eliminarSeleccionados') }}')">
                            <i class="fas fa-trash-alt"></i> Eliminar seleccionados
                        </button>
                        <button type="submit" class="btn btn-pagar btn-sm" onclick="setAction('{{ route('carrito.pagar') }}')">
                            <i class="fas fa-money-bill-wave"></i> Pagar
                        </button>
                    </div>
                </form>

                <script>
                    function actualizarTotal() {
                        let total = 0;
                        document.querySelectorAll('.checkbox-producto').forEach(checkbox => {
                            if (checkbox.checked) {
                                let subtotal = parseFloat(checkbox.getAttribute('data-subtotal'));
                                total += subtotal;
                            }
                        });
                        document.getElementById('total').textContent = total.toFixed(2);
                    }

                    function actualizarSubtotal(input, productoId) {
                        let cantidad = parseInt(input.value);
                        let precio = parseFloat(input.closest('tr').querySelector('td:nth-child(4)').textContent.replace('$', '').trim());
                        let subtotal = cantidad * precio;
                        input.closest('tr').querySelector('.subtotal-producto').textContent = `$${subtotal.toFixed(2)}`;
                        input.closest('tr').querySelector('.checkbox-producto').setAttribute('data-subtotal', subtotal);
                        actualizarTotal();
                    }

                    function setAction(route) {
                        const form = document.getElementById('carritoForm');
                        form.action = route;

                        const productosSeleccionados = document.querySelectorAll('.checkbox-producto:checked');
                        productosSeleccionados.forEach(checkbox => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'productos_seleccionados[]';
                            input.value = checkbox.value;
                            form.appendChild(input);

                            const cantidadInput = checkbox.closest('tr').querySelector('.cantidad-producto');
                            const inputCantidad = document.createElement('input');
                            inputCantidad.type = 'hidden';
                            inputCantidad.name = `cantidad_${checkbox.value}`;
                            inputCantidad.value = cantidadInput.value;
                            form.appendChild(inputCantidad);
                        });
                    }
                    
                    actualizarTotal();
                </script>
            @endif
        </div>
    </div>
</div>
@endsection
