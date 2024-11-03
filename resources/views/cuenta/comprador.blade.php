@extends('layouts.app')

@section('content')
<style>
    .col-md-9, .col-lg-10 {
        padding: 0; /* Elimina el padding para evitar espacios innecesarios */
        min-height: 100vh; /* Asegúrate de que el área principal ocupe toda la altura */
        margin-left: 230px; /* Asegúrate de que el área principal comience después del menú */
        background-color: #c1c6ca; /* Color de fondo del body */
    }
</style>

<div class="container">
    <div class="container-fluid"> 
        <!-- Menú lateral -->
        <div class="custom-menu {{ request()->is('productos/create') || request()->is('productos/*/edit') || request()->is('productos/*') ? 'd-none' : '' }}">
            @include('partials.menu-lateral')
        </div>
        <!-- Contenido -->
        <div class="col">
            <div class="row d-flex align-items-center mb-4">
                <div class="col-md-8">
                    <h2 class="display-4 mb-0">Perfil como Comprador</h2>
                </div>
                <div class="col-md-4 text-md-end">
                    <img src="{{ asset('assets/img/perfilComprador.png') }}" alt="Ilustración" class="img-fluid" style="width: 200px; height: auto;">
                </div>
            </div>    
            <!-- Datos del perfil -->
            <div class="row  align-items-center">
                <div class="col-md-8">
                    <h4 class="fw-bold"><strong>ID de usuario:</strong> {{ Auth::user()->id }} </h4>
                    <h4 class="fw-bold"><strong>Nombre:</strong> {{ $user->nombre }} {{ $user->apellido }}</h4>
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
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto de perfil" class="img-fluid rounded-circle">
                </div>
            </div>
            <!-- Información de los productos -->
            <h3>Mis Compras</h3>
                @if($compras->isEmpty())
                    <p>No tienes compras registradas.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Fecha de compra</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($compras as $compra)
                                <tr>
                                    <td>{{ $compra->producto->nombre }}</td>
                                    <td>{{ $compra->fecha_compra }}</td>
                                    <td>{{ $compra->precio }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                
            <h3>Mis reseñas como vendedor</h3>
            @if($order->isCompleted() && !$order->hasBuyerReview())
                <!-- Formulario para dejar reseña al vendedor y al producto -->
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="reviewable_id" value="{{ $order->product->id }}">
                    <input type="hidden" name="reviewable_type" value="App\Models\Product">
                    
                    <label for="review">Reseña del Producto:</label>
                    <textarea name="review" required></textarea>
                    
                    <label for="rating">Calificación del Producto:</label>
                    <select name="rating" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>

                    <input type="hidden" name="reviewable_id" value="{{ $order->seller->id }}">
                    <input type="hidden" name="reviewable_type" value="App\Models\User">

                    <label for="review">Reseña del Vendedor:</label>
                    <textarea name="review" required></textarea>

                    <label for="rating">Calificación del Vendedor:</label>
                    <select name="rating" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>

                    <button type="submit">Enviar Reseñas</button>
                </form>
            @endif

            @foreach($user->reviewsReceived as $review)
                <p>{{ $review->review }}</p>
                <p>Calificación: {{ $review->rating }}</p>
                <p>Por: {{ $review->user->name }}</p>
            @endforeach
        </div>
    </div>
</div>
@endsection
