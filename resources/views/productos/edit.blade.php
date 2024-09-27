@extends('layouts.app')

@section('content')
    <h2>Editar Producto</h2>

    <form action="{{ route('productos.update', $producto->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>ID:</label>
        <input type="number" name="id" value="{{ $producto->id }}">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="{{ $producto->nombre }}">
        
        <label>Descripción:</label>
        <textarea name="descripcion">{{ $producto->descripcion }}</textarea>
        
        <label>Precio:</label>
        <input type="number" name="precio" value="{{ $producto->precio }}" step="0.01">
        
        <label>Cantidad:</label>
        <input type="number" name="cantidad" value="{{ $producto->cantidad }}">

        <label>Vendedor ID:</label>
        <input type="number" name="vendedor_id" value="{{ $producto->vendedor_id }}">
        
        <button type="submit">Actualizar</button>
    </form>
@endsection
