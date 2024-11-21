@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="custom-menu">
            @include('partials.menu-lateral')
        </div> 
        <!-- Contenido -->
        <div class="contenidoPrincipal">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <h2 class="mb-4" class="text-center display-4">Carrito de compras</h2>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <img src="{{ asset('assets/img/carrito1.png') }}" alt="Imagen izquierda" class="imagen-izquierdaCarrito">
                @if ($carritos->isNotEmpty())
                    <h2>A continuación, verás tus productos a comprar.</h2>
                @else
                    <h2>No tienes productos por comprar.</h2>
                @endif
                <img src="{{ asset('assets/img/carrito2.png') }}" alt="Imagen derecha" class="imagen-derechaCarrito">
            </div>
            @if($carritos->isEmpty())
                <h2>¡Agrega algún producto a tu carrito para comprarlo!</h2>
            @else
                @if(auth()->check())        
                    <!-- Muestra los productos en el carrito aquí -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Seleccionar</th>
                                    <th>Vista previa</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carritos as $producto)
                                <tr>
                                    <!-- Checkbox -->
                                    <td>
                                        <input type="checkbox" name="selected_products[]" value="{{ $producto->id }}" class="select-product">
                                    </td>
                                    <!-- Imagen del producto -->
                                    <td>
                                        @if($producto->images->first())
                                            <img src="{{ $producto->images->first()->url }}" alt="{{ $producto->nombre }}" class="producto-imgCarrito">
                                        @else
                                            <img src="{{ asset('assets/img/placeholder.png') }}" alt="Sin imagen" class="producto-img">
                                        @endif
                                    </td>
                                    <!-- Nombre del producto -->
                                    <td>
                                        {{ $producto->nombre }}
                                    </td>                                
                                    <!-- Precio del producto -->  
                                    <td class="precio-producto-carrito" data-precio="{{ $producto->precio }}">
                                        ${{ number_format($producto->precio, 2) }}
                                    </td> 
                                    <!-- Cantidad -->
                                    <td>
                                        <input type="number" class="cantidad-producto form-control" value="1" min="1" step="1">
                                    </td>
                                    <!-- Subtotal  -->
                                    <td class="subtotal-producto">${{ number_format($producto->precio, 2) }}</td> <!-- Nuevo subtotal -->
                                    <!-- Opciones -->
                                    <td>
                                        <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-verProductIndex btn-sm" title="Ver detalles del producto">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    <!-- Botón para eliminar producto del carrito -->
                                        <form action="{{ route('carrito.eliminar', ['producto' => $producto->id]) }}" method="POST" class="d-inline-block botonEliminarProductoDelCarrito">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-eliminarProductIndex btn-sm mx-1" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto del carrito?');">
                                                <i class="fas fa-trash-alt"></i> Quitar del carrito
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="total-container mt-3">
                        <p class="totalAPagar"><strong>Total: $<span id="total-precio">0.00</span></strong></p>
                    </div>
                    <!-- Selección de método de pago -->
                    <h3>Método de Pago</h3>
                    @if(count($paymentMethods) > 0)
                        <label for="payment-method">Selecciona un método de pago:</label>
                        <select id="payment-method" name="payment_method_id" class="form-control">
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}">
                                    **** {{ $method->card->last4 }} ({{ $method->card->brand }})
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p>No tienes métodos de pago guardados. Agrega uno en la sección "Mi cuenta".</p>
                    @endif

                    <!-- Formulario para proceder con el pago -->
                    @if(count($paymentMethods) > 0)
                        <form id="form-pago" action="{{ route('carrito.pagar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="productos_seleccionados" value="{{ json_encode($productosSeleccionados) }}">
                            <input type="hidden" name="payment_method_id" id="payment-method-id" value="{{ $paymentMethods[0]->id }}">
                            <button type="submit" class="btn btn-primary mt-3">Pagar</button>
                        </form>
                    @endif
                @else
                    <h2 class="text-center">Por favor, inicia sesión para ver los productos en tu carrito.</h1>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
