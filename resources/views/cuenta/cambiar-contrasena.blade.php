@extends('layouts.app')

@section('content')

<div class="container-fluid">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <!-- Contenido Principal -->
    <div class="contenidoCambiarContraseña">
        <h2 class="text-center">Cambiar Contraseña</h2>
        <!-- Contenedor para la imagen y el formulario -->
        <div class="row">
            <!-- Columna de la imagen -->
            <div class="col-md-4">
                <img src="{{ asset('assets/img/cambiarContrasena.png') }}" alt="Descripción de la imagen" class="img-fluid">
            </div>
            <!-- Columna del formulario -->
            <div class="col-md-8">
                <form action="{{ route('cuenta.cambiar-contrasena.form') }}" method="POST">
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
</div>

@endsection
