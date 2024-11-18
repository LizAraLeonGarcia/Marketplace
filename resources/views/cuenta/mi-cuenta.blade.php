@extends('layouts.app')

@section('title', 'Vaquita Marketplace')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('info'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="custom-menu">
            @include('partials.menu-lateral') <!-- Menú lateral -->
        </div>
        <!-- Contenido -->
        <div class="contenidoPrincipal">
            <h2 class="mb-4" class="text-center display-4">Mi cuenta</h2>
            <!-- Contenedor con imágenes y navegación -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <!-- Imagen izquierda -->
                <img src="{{ asset('assets/img/miCuenta1.png') }}" alt="Icono izquierdo" class="img-fluid mx-3" style="max-width: 200px; height: auto;">
                <!-- botones -->
                <div class="d-flex align-items-center justify-content-between mb-4 contenedor-botones">
                    <a href="{{ route('cuenta.editar') }}" class="btn btn-editarCuenta">Editar cuenta</a>
                    <a href="{{ route('cuenta.cambiar-contrasena.form') }}" class="btn btn-cambiarContraseña">Cambiar contraseña</a>    
                    <a href="{{ route('metodo-de-pago.show') }}" class="btn btn-metodoPago">Método de pago</a>
                    <a href="{{ route('cuenta.eliminar.form') }}" class="btn btn-eliminarCuenta" >Eliminar mi cuenta</a>  
                </div>  
                <!-- Imagen derecha -->
                <img src="{{ asset('assets/img/miCuenta2.png') }}" alt="Icono derecho" class="img-fluid mx-3" style="max-width: 200px; height: auto;">
            </div>
            <!-- Verificar si el usuario ha completado los campos obligatorios -->
            @if (empty($user->sexo) || empty($user->pais) || empty($user->fecha_nacimiento) || empty($user->nombre) || empty($user->apellido))
                <div class="card mb-4 shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h5 mb-0">Completa tu perfil</h2>
                    </div>
                    <div class="card-body">
                        <p>Por favor, completa la información obligatoria de tu perfil.</p>
                        <a href="{{ route('cuenta.editar') }}" class="btn btn-primary">Completar perfil</a>
                    </div>
                </div>
            @else
                <!-- Información del usuario -->
                <div class="card-body">
                    <div class="row">
                        <!-- Columna de la imagen -->
                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                            @if(Str::startsWith($user->foto, 'public/imagenes'))
                                <!-- Mostrar la foto subida por el usuario -->
                                <img src="{{ Storage::url($user->foto) }}" alt="Foto de perfil personalizada" class="img-fluid rounded-circle border border-3" style="max-width: 350px; height: auto;" />
                            @else
                                <!-- Mostrar la imagen predeterminada -->
                                <img src="{{ asset($user->foto) }}" alt="Foto de perfil predeterminada" class="img-fluid rounded-circle border border-3" style="max-width: 350px; height: auto;" />
                            @endif
                        </div>
                        <!-- Columna de la información -->
                        <div class="col-md-8">
                            <div class="bg-white p-3 rounded">
                                <h3 class="fw-bold text-center"><strong>Información de la cuenta</strong></h3>
                                <h4 class="fw-bold"><strong>ID de usuario:</strong> {{ Auth::user()->id }} </h4>
                                <h4 class="fw-bold"><strong>Nombre:</strong> {{ $user->nombre }} {{ $user->apellido }}</h4>
                                <h5><strong>Apodo:</strong> {{ $user->apodo ?? 'No especificado' }}</h5>
                                <p><strong>Sexo:</strong> {{ $user->sexo }}</p>
                                <p><strong>País:</strong> {{ $user->pais->nombre ?? 'No especificado' }}</p>
                                <p><strong>Fecha de Nacimiento:</strong> {{ $user->fecha_nacimiento ? $user->fecha_nacimiento->format('d/m/Y') : 'No especificada' }}</p>
                                <p><strong>Descripción:</strong> {{ $user->descripcion ?? 'No especificada' }}</p>
                                <p><strong>Correo:</strong> {{ $user->email }}</p>
                                <p><strong>Correo verificado:</strong> 
                                    @if (Auth::user()->hasVerifiedEmail())
                                        <span class="badge bg-success text-white">Sí</span>
                                    @else
                                        <span class="badge bg-danger text-white">No</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
