@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
    <div class="container">
        <h2 class="text-center">Editar Producto</h2>
        <!-- Formulario para editar producto -->
        <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Nombre del Producto -->
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $producto->nombre) }}" required>
                @error('nombre')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <!-- Descripción del Producto -->
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                @error('descripcion')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <!-- Precio del Producto -->
            <div class="form-group">
                <label for="precio">Precio ($)</label>
                <input type="number" name="precio" id="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio', $producto->precio) }}" step="0.01" required>
                @error('precio')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <!-- Cantidad del Producto -->
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $producto->stock) }}" required>
                @error('stock')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <!-- Imagen del Producto -->
            <div class="form-group">
                <label for="imagen">Imagen del Producto (opcional)</label>
                <input type="file" name="imagen" id="imagen" class="form-control @error('imagen') is-invalid @enderror" accept="image/*">
                <small class="form-text text-muted">Imagen actual: 
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen del producto" style="max-width: 150px; max-height: 150px;">
                </small>
                @error('imagen')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <!-- Botón de Actualizar -->
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection