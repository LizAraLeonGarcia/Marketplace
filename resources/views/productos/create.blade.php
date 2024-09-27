@extends('layouts.app')

@section('content')
    <h2>Crear Producto</h2>

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf
        <label>ID:</label>
        <input type="number" name="id">

        <label>Nombre:</label>
        <input type="text" name="nombre">
        
        <label>Descripción:</label>
        <textarea name="descripcion"></textarea>
        
        <label>Precio:</label>
        <input type="number" name="precio" step="0.01">
        
        <label>Cantidad:</label>
        <input type="number" name="cantidad">

        <label>Vendedor ID:</label>
        <input type="number" name="vendedor_id">
        
        <button type="submit">Guardar</button>
    </form>
@endsection
