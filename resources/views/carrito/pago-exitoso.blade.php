@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="alert alert-success">
        <h2>{{ session('message') }}</h2>
        <p class="text-center">Gracias por tu compra.  Tu pedido ha sido procesado correctamente.</p>
        <img src="{{ asset('assets/img/pagoExitoso.png') }}" alt="Imagen pago exitoso" class="imagen-pagoExitoso">
    </div>
</div>
@endsection
