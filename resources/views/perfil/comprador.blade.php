@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Perfil de Comprador</h1>

    <h3>Historial de Compras</h3>
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
    <h3>Mis reseñas como vendedor</h3>

</div>
@endsection
