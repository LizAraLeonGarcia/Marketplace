@extends('layouts.app')

@section('title', "Productos en la categoría $categoria")

@section('content')
<div class="container">
    <h2 class="mb-4">Productos en la categoría: {{ $categoria }}</h2>

    @if($productos->count())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>${{ number_format($producto->precio, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $productos->links() }} <!-- Paginación -->
    @else
        <p>No hay productos en esta categoría.</p>
    @endif
</div>
@endsection
