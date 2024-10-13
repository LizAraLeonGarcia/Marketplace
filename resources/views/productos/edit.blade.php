@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
    <div class="container">
        <h2 class="mb-4">Editar Producto</h2>

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

        <!-- Formulario para editar producto -->
        <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre del producto" value="{{ old('nombre', $producto->nombre) }}" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" id="descripcion" rows="3" placeholder="Descripción del producto" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio ($)</label>
                <input type="number" name="precio" class="form-control" id="precio" placeholder="0.00" step="0.01" value="{{ old('precio', $producto->precio) }}" required>
            </div>

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" name="cantidad" class="form-control" id="cantidad" placeholder="Cantidad disponible" value="{{ old('cantidad', $producto->cantidad) }}" required>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Producto (opcional)</label>
                <input type="file" name="imagen" class="form-control" id="imagen">
                <small class="form-text text-muted">La imagen actual es: {{ $producto->imagen }}</small>
            </div>

            <div class="mb-3">
                <label for="vendedor_id" class="form-label">ID del Vendedor</label>
                <input type="number" name="vendedor_id" class="form-control" id="vendedor_id" value="{{ old('vendedor_id', $producto->vendedor_id) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
