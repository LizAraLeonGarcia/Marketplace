@extends('layouts.app')

@section('content')
    <h2>Productos</h2>
    <a href="{{ route('productos.create') }}">Crear Producto</a>

    <ul>
        @foreach ($productos as $producto)
            <li>
                <a href="{{ route('productos.show', $producto->id) }}">
                    {{ $producto->nombre }}
                </a>
                <a href="{{ route('productos.edit', $producto->id) }}">Editar</a>
                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
