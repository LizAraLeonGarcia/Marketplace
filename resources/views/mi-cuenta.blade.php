@extends('layouts.app')

@section('title', 'Mi Cuenta')

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
        <div class="custom-menu {{ request()->is('productos/create') || request()->is('productos/*/edit') || request()->is('productos/*') ? 'd-none' : '' }}">
            @include('partials.menu-lateral') <!-- Menú lateral -->
        </div>
        <!-- Contenido -->
        <div class="col">
            <h2 class="mb-4" class="text-center display-4">Mi cuenta</h2>
            <!-- Contenedor con imágenes y navegación -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <!-- Imagen izquierda -->
                <img src="{{ asset('assets/img/miCuenta1.png') }}" alt="Icono izquierdo" class="img-fluid" style="height: 240px;">
                <nav>
                    <ul class="nav nav-pills mb-4">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('perfil.editar') }}">Editar cuenta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Cambiar contraseña</a>    
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Metodo de pago</a>
                        </li>
                    </ul>
                </nav>    
                <!-- Imagen derecha -->
                <img src="{{ asset('assets/img/miCuenta2.png') }}" alt="Icono derecho" class="img-fluid" style="height: 240px;">
            </div>
            <!-- Verificar si el usuario ha completado los campos obligatorios -->
            @if (empty($user->sexo) || empty($user->pais) || empty($user->fecha_nacimiento) || empty($user->nombre) || empty($user->apellido))
                <div class="card mb-4 shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h5 mb-0">Completa tu perfil</h2>
                    </div>
                    <div class="card-body">
                        <p>Por favor, completa la información obligatoria de tu perfil.</p>
                        <a href="{{ route('perfil.editar') }}" class="btn btn-primary">Completar perfil</a>
                    </div>
                </div>
            @else
                <!-- Información del usuario -->
                <div class="card mb-4 shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-secondary text-white">
                        <h2 class="h5 mb-0">Información de la Cuenta</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('images/default-profile.png') }}" 
                                alt="Foto de perfil" class="img-fluid rounded-circle shadow">
                            </div>
                            <div class="col-md-8">
                                <h5 class="fw-bold">Nombre: {{ $user->nombre }} {{ $user->apellido }}</h5>
                                <p><strong>Apodo:</strong> {{ $user->apodo ?? 'No especificado' }}</p>
                                <p><strong>Sexo:</strong> {{ $user->sexo }}</p>
                                <p><strong>País:</strong> {{ $user->pais }}</p>
                                <p><strong>Fecha de Nacimiento:</strong> {{ $user->fecha_nacimiento ? $user->fecha_nacimiento->format('d/m/Y') : 'No especificada' }}</p>
                                <p><strong>Descripción:</strong> {{ $user->descripcion ?? 'No especificada' }}</p>
                                <p><strong>Correo:</strong> {{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
