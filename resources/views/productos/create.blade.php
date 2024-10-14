@extends('layouts.app') <!-- Extiende tu diseño principal -->

@section('content')
<div class="container">
    <h1 class="text-center">Crear Producto</h1>
    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- Incluir token de CSRF para la seguridad -->
        
        <!-- Nombre del Producto -->
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
            @error('nombre')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Descripción del Producto -->
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Precio del Producto -->
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio') }}" required step="0.01">
            @error('precio')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Cantidad del Producto -->
        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad') }}" required>
            @error('cantidad')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Imagen del Producto -->
        <div class="form-group">
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen" id="imagen" class="form-control @error('imagen') is-invalid @enderror" accept="image/*" required>
            @error('imagen')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Botón de Enviar -->
        <button type="submit" class="btn btn-primary">Crear Producto</button>
    </form>
</div>
@endsection