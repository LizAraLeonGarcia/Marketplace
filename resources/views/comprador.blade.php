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

            <div class="col-md-8">
                <h5 class="fw-bold">ID del usuario: {{ $user->id }} </h5>
                <h5 class="fw-bold">Nombre: {{ $user->nombre }} {{ $user->apellido }}</h5>
                <p><strong>Apodo:</strong> {{ $user->apodo ?? 'No especificado' }}</p>
                <p><strong>País:</strong> {{ $user->pais->nombre ?? 'No especificado' }}</p>
                <p><strong>Correo:</strong> {{ $user->email }}</p>
            </div>

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
        </div>
    </div>
</div>
@endsection
