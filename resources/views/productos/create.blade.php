@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
    <div class="container">
        <h2 class="mb-4">Crear Producto</h2>

        <!-- Mensaje de error de validación -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario para crear producto -->
        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <input type="number" name="id" class="form-control" id="id" value="{{ old('id') }}" required>
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" id="nombre" value="{{ old('nombre') }}" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" id="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" name="precio" class="form-control" id="precio" step="0.01" value="{{ old('precio') }}" required>
            </div>

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" name="cantidad" class="form-control" id="cantidad" value="{{ old('cantidad') }}" required>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Producto</label>
                <input type="file" name="imagen" class="form-control" id="imagen">
            </div>

            <div class="mb-3">
                <label for="vendedor_id" class="form-label">ID del Vendedor</label>
                <input type="number" name="vendedor_id" class="form-control" id="vendedor_id" value="{{ old('vendedor_id') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
