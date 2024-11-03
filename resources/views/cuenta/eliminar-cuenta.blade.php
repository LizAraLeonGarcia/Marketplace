@extends('layouts.app')

@section('title', 'Eliminar Cuenta')

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
        font-weight: bold;
    }

    .btn-danger {
        background-color: red;
        border: none;
        transition: background-color 0.3s;
    }

    .btn-danger:hover {
        background-color: darkred; 
    }

    .btn-secondary {
        margin-top: 20px; /* Separación entre botones */
        background-color: blue;
    }

    .btn-secondary:hover {
        background-color: darkblue;
    }
</style>

<div class="contenido">
    <h2 class="text-center">Eliminar Cuenta</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="alert alert-warning">
                <strong>Advertencia:</strong> Al eliminar tu cuenta, se perderán todos tus datos de forma permanente.
            </div>
            <p><strong>Por favor, confirma que deseas eliminar tu cuenta.</strong></p>
            <div class="d-flex justify-content-center">
                <form action="{{ route('cuenta.eliminar') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.')" class="me-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar mi cuenta</button>
                </form>
            </div>
            <div class="text-center">
                <a href="{{ route('cuenta.editar') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
        <div class="col-md-4 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/img/eliminarCuenta.png') }}" alt="Descripción de la imagen" class="img-fluid">
        </div>
    </div>
</div>
@endsection
