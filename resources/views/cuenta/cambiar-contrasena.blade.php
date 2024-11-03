@extends('layouts.app')

@section('content')
<style>
    .col-md-9, .col-lg-10 {
        padding: 0; /* Elimina el padding para evitar espacios innecesarios */
        min-height: 100vh; /* Asegúrate de que el área principal ocupe toda la altura */
        margin-left: 230px; /* Asegúrate de que el área principal comience después del menú */
        background-color: #c1c6ca; /* Color de fondo del body */
    }

    .contenido {
        text-align: center;
        justify-content: center;
        align-items: center; 
        overflow-x: hidden; /* Oculta cualquier desbordamiento horizontal */
    }

    .alert {
        margin-bottom: 20px; /* Espacio debajo de la alerta */
    }

    .form-control {
        border-radius: 5px; /* Bordes redondeados en los campos de formulario */
    }

    label.form-label {
        font-size: 1.1rem; /* Aumenta el tamaño de la fuente */
        color: #555; /* Cambia el color del texto */
        margin-bottom: 0.5rem; /* Espacio debajo de la etiqueta */
        font-weight: bold; /* Pone el texto en negrita */
    }

    .invalid-feedback {
        font-size: 0.9rem; /* Tamaño de fuente para mensajes de error */
        color: #dc3545; /* Color rojo para el texto de error */
        margin-top: 0.25rem; /* Espacio por encima del mensaje de error */
    }

    .btn-cambiarContrasena {
        background: black !important;
        color: #c1c6ca !important;
    }

    .btn-cambiarContrasena:hover {
        background: lightpink !important;
        color: black !important;
    }
    .img-fluid {
        max-width: 100%; /* Asegura que la imagen sea responsiva */
        height: auto; /* Mantiene la proporción de la imagen */
    }
</style>

<div class="contenido">
    <h2 class="text-center">Cambiar contraseña</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/img/cambiarContrasena.png') }}" alt="Descripción de la imagen" class="img-fluid">
        </div>
        <div class="col-md-8">
            <form action="{{ route('cuenta.cambiar-contrasena') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="current_password" class="form-label">Contraseña Actual</label>
                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                    @error('current_password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
                    @error('new_password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-cambiarContrasena">Cambiar Contraseña</button>
            </form>
        </div>
    </div>
</div>
@endsection
