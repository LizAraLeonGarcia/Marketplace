@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<style>
    body {
        background-image: url('{{ asset('img/fondoFormEdit.jpg') }}'); /* Ajusta la ruta según sea necesario */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font-family: 'Times New Roman', Times, serif;
        min-height: 100vh; /* Asegúrate de que el body tenga la altura de la ventana */
        display: flex;
        justify-content: center; /* Centra el contenido horizontalmente */
        align-items: flex-start; /* Alinea el contenido en la parte superior */
        flex-direction: column; /* Coloca el contenido en columna */
        padding: 20px; /* Agrega un poco de espacio alrededor */
    }
    .form-container {
        max-width: 800px; /* Ajusta el tamaño máximo del formulario */
        padding: 40px;
        border-radius: 15px;
        background-color: transparent; /* Mantiene el fondo completamente transparente */
        margin: 20px auto; /* Centra el contenedor */
        box-shadow: none; /* Elimina la sombra si no es necesaria */
    }
    .form-group label {
        background-color: rgba(255, 255, 255, 0.8); /* Fondo semitransparente para las etiquetas */
        padding: 5px; /* Espacio interno para las etiquetas */
        border-radius: 5px; /* Esquinas redondeadas para las etiquetas */
        color: #333; /* Color del texto de las etiquetas */
    }
    .image-container {
        display: flex;
        justify-content: space-around;
        margin-top: 40px;
        width: 100%; /* Asegura que la imagen se ajuste al contenedor */
    }
    .image-container img {
        max-width: 30%;
        border-radius: 10px;
    }
    .btn-container {
        display: flex;
        justify-content: space-between; /* Asegura que los botones estén a los lados */
        margin-top: 20px; /* Espacio entre el formulario y los botones */
    }
</style>

<div class="container form-container">
    <h2 class="text-center">Editar Producto</h2>
    
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

        <!-- Stock del Producto -->
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $producto->stock) }}" required>
            @error('stock')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Categoría del Producto -->
        <div class="form-group">
            <label for="categoria_id">Categoría</label>
            <select name="categoria_id" id="categoria_id" class="form-control @error('categoria_id') is-invalid @enderror" required>
                <option value="">Seleccionar categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id')
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

        <!-- Botones de Actualizar y Cancelar -->
        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

    <!-- Sección de Imágenes -->
    <div class="image-container">
        <img src="{{ asset('img/editar1.png') }}" alt="Imagen 1">
        <img src="{{ asset('img/editar2.png') }}" alt="Imagen 2">
        <img src="{{ asset('img/editar3.png') }}" alt="Imagen 3">
    </div>
</div>
@endsection
