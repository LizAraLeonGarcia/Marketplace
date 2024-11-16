@extends('layouts.app')

@section('title', 'Eliminar Cuenta')

@section('content')

<div class="eliminarCuenta">
    <h2 class="text-center">Eliminar Cuenta</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="alert alert-warning">
                <strong>Advertencia:</strong> Al eliminar tu cuenta, se perderán todos tus datos de forma permanente.
            </div>
            <p class="parrafoConfirmar"><strong>Por favor, confirma que deseas eliminar tu cuenta.</strong></p>
            <div class="d-flex justify-content-center">
                <form action="{{ route('cuenta.eliminar') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.')" class="me-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar mi cuenta</button>
                </form>
            </div>
            <div class="text-center">
                <a href="{{ route('cuenta.editar') }}" class="btn btn-cancelarEliminarCuenta">Cancelar</a>
            </div>
        </div>
        <div class="col-md-4 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/img/eliminarCuenta.png') }}" alt="Descripción de la imagen" class="img-fluid">
        </div>
    </div>
</div>
@endsection
