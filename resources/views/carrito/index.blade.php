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

    .table th, .table td {
        text-align: center;
    }

    .producto-img {
        width: 80px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
    }

    .table td .form-control {
        width: 80px;
        text-align: center;
        margin: auto;
    }

    .total {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-top: 20px;
        text-align: end;
    }

    .btn-pagar {
        background-color: green !important;
        color: white !important;
    }

    .btn-basura {
        background-color: red !important;
        color: white !important;
    }

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
            @php $total = 0; @endphp
                <form action="{{ route('carrito.pagar') }}" method="POST" id="formPagar">
                    @csrf
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
                                        <input type="checkbox" name="productos_seleccionados[]" value="{{ $producto->id }}" class="form-check-input checkbox-producto" data-subtotal="{{ $subtotal }}" onchange="actualizarTotal()">
                                    </td>
                                    <td>
                                        @if($producto->images->first())
                                            <img src="{{ $producto->images->first()->url }}" alt="{{ $producto->nombre }}" class="producto-img">
                                        @else
                                            <img src="{{ asset('assets/img/placeholder.png') }}" alt="Sin imagen" class="producto-img">
                                        @endif
                                    </td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>${{ number_format($producto->precio, 2) }}</td>
                                    <td>
                                        <input type="number" min="1" max="{{ $producto->stock }}" value="{{ $producto->pivot->cantidad }}" class="form-control cantidad-producto" data-id="{{ $producto->id }}" data-precio="{{ $producto->precio }}" onchange="actualizarSubtotal(this)">
                                    </td>
                                    <td><span class="subtotal-producto" id="subtotal-{{ $producto->id }}">${{ number_format($subtotal, 2) }}</span></td>
                                    <td>
                                        <a href="{{ route('productos.show', $producto) }}" class="btn btn-detalles btn-sm"> <i class="fas fa-eye"></i> Ver Detalles</a>

                                        <!-- Formulario de eliminación independiente -->
                                        <form action="{{ route('carrito.eliminar', $producto->id) }}" method="POST" class="d-inline-block form-eliminar-producto">
                                            @csrf
                                            <button type="submit" class="btn btn-basura btn-sm"><i class="fas fa-trash"></i> Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="total">Total: $<span id="total">{{ number_format($total, 2) }}</span></div>
                    <!-- Campo hidden para enviar productos y sus cantidades -->
                    <input type="hidden" name="productos" id="productos" value="">

                    <!-- Botón para pagar productos seleccionados -->
                    <button type="submit" id="btnPagar" class="btn btn-pagar btn-sm">
                        <i class="fas fa-money-bill-wave"></i> Pagar
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        actualizarTotal(); // Llamar a actualizarTotal al cargar la página para establecer el total inicial en 0 si no hay seleccionados.
    });

    function actualizarTotal() {
        let total = 0;
        // Obtener todos los checkboxes seleccionados
        let checkboxes = document.querySelectorAll('.checkbox-producto:checked');

        checkboxes.forEach(function(checkbox) {
            // Obtener el subtotal guardado en el checkbox
            let subtotal = parseFloat(checkbox.dataset.subtotal);
            total += subtotal;
        });
        // Si no hay productos seleccionados, el total debe ser 0
        if (checkboxes.length === 0) {
            total = 0;
        }
        // Actualizar el total en la página
        document.getElementById('total').innerText = total.toFixed(2);
        // Actualizar el campo hidden con los productos seleccionados y sus cantidades
        let productosSeleccionados = [];
        checkboxes.forEach(function(checkbox) {
            let cantidad = document.querySelector(`.cantidad-producto[data-id='${checkbox.value}']`).value;
            productosSeleccionados.push({
                id: checkbox.value,
                cantidad: cantidad
            });
        });
        document.getElementById('productos').value = JSON.stringify(productosSeleccionados);
    }
    // Actualizar el subtotal de cada producto
    function actualizarSubtotal(input) {
        let cantidad = parseFloat(input.value);
        let precio = parseFloat(input.dataset.precio);
        let subtotal = cantidad * precio;

        // Actualizar el subtotal en la vista
        let subtotalElemento = document.getElementById(`subtotal-${input.dataset.id}`);
        subtotalElemento.innerText = `$${subtotal.toFixed(2)}`;

        // Actualizar el data-subtotal en el checkbox para este producto
        let checkbox = document.querySelector(`.checkbox-producto[value='${input.dataset.id}']`);
        checkbox.dataset.subtotal = subtotal;

        // Actualizar el total general
        actualizarTotal();
    }
    // Eliminar el producto con AJAX sin que el checkbox interfiera
    document.querySelectorAll('.form-eliminar-producto').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('¿Estás seguro de que deseas eliminar este producto del carrito?')) {
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Remover el producto de la tabla
                        this.closest('tr').remove();
                        actualizarTotal(); // Actualizar el total después de eliminar
                    } else {
                        alert('No se pudo eliminar el producto. Intenta de nuevo.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });
</script>
@endsection
