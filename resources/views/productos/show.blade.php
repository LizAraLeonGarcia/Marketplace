@extends('layouts.app')

@section('content')
    <h2>{{ $producto->ID }}</h2>
    <h2>{{ $producto->nombre }}</h2>
    <p>{{ $producto->descripcion }}</p>
    <p>Precio: {{ $producto->precio }}</p>
    <p>Cantidad: {{ $producto->cantidad }}</p>
    <p>Vendedor ID: {{$producto->vendedor_id}}</p>
@endsection
