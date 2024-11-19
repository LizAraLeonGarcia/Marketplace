@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <!-- Menú lateral -->
        <div class="custom-menu">
            @include('partials.menu-lateral')
        </div>
        <!-- Contenido -->
        <div class="contenidoPrincipal">
            <div class="row d-flex align-items-center mb-4">
                <div class="col-md-8">
                    <h2 class="display-4 mb-0">Perfil como Vendedor</h2>
                </div>
                <div class="col-md-4 text-md-end">
                    <img src="{{ asset('assets/img/perfilVendedor.png') }}" alt="Ilustración" class="img-fluid" style="width: 200px; height: auto;">
                </div>
            </div>
            <!-- Datos del perfil -->
            <div class="row  align-items-center">
                <div class="col-md-8">
                    <h5 class="fw-bold"><strong>ID de usuario:</strong> {{ Auth::user()->id }} </h5>
                    <h5 class="fw-bold"><strong>Nombre:</strong> {{ $user->nombre }} {{ $user->apellido }}</h5>
                    <h5><strong>Apodo:</strong> {{ $user->apodo ?? 'No especificado' }}</h5>
                    <p><strong>País:</strong> {{ $user->pais->nombre ?? 'No especificado' }}</p>
                    <p><strong>Descripción:</strong> {{ $user->descripcion ?? 'No especificada' }}</p>
                    <p><strong>Correo verificado:</strong> 
                        @if (Auth::user()->hasVerifiedEmail())
                            <span class="badge bg-success text-white">Sí</span>
                        @else
                            <span class="badge bg-danger text-white">No</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    @if(Str::startsWith($user->foto, 'public/imagenes'))
                        <!-- Mostrar la foto subida por el usuario -->
                        <img src="{{ Storage::url($user->foto) }}" alt="Foto de perfil personalizada" class="img-fluid rounded-circle border border-3" style="max-width: 350px; height: auto;" />
                    @else
                        <!-- Mostrar la imagen predeterminada -->
                        <img src="{{ asset($user->foto) }}" alt="Foto de perfil predeterminada" class="img-fluid rounded-circle border border-3" style="max-width: 350px; height: auto;" />
                    @endif  
                </div>
            </div>
            <!-- Información de los productos -->
            <h3>Mis Productos</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre del Producto</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>{{ $producto->precio }}</td>
                            <td>
                                <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-info btn-sm" title="Ver detalles del producto">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm" title="Editar producto">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar producto" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <h3>Mis reseñas como vendedor</h3>
            @if($order && $order->isCompleted() && $order->hasBuyerReview() && !$order->hasSellerReview())
            <!-- Sección para dejar reseña al comprador -->
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="reviewable_id" value="{{ $order->buyer->id }}">
                    <input type="hidden" name="reviewable_type" value="App\Models\User">

                    <label for="review">Reseña del Comprador:</label>
                    <textarea name="review" required></textarea>

                    <label for="rating">Calificación del Comprador:</label>
                    <select name="rating" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <button type="submit">Enviar Reseña</button>
                </form>
            @endif

            @if($user->reviewsReceived && $user->reviewsReceived->isNotEmpty())
                @foreach($user->reviewsReceived as $review)
                    <p>{{ $review->review }}</p>
                    <p>Calificación: {{ $review->rating }}</p>
                    <p>Por: {{ $review->user->name }}</p>
                @endforeach
            @else
                <p>No has recibido reseñas aún.</p>
            @endif
        </div>
    </div>
@endsection
