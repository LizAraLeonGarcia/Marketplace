@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<style>
    body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    background-image: url('{{ asset('img/fondoFormEdit.jpg') }}');
    background-size: cover;
    background-position: center;
    font-family: 'Times New Roman', Times, serif;
    overflow-x: hidden; /* Oculta la barra de desplazamiento horizontal */
}

.main-container {
    height: 100%; /* Usa 100% para ocupar el alto total disponible */
    display: flex;
    flex-direction: column; /* Mantiene los elementos en una columna */
    justify-content: flex-start; /* Asegura que comience desde la parte superior */
    align-items: center; /* Centra horizontalmente */
    padding: 20px; /* Espaciado alrededor del contenedor */
}

h2 {
    margin: 20px 0; 
    color: #f39c12; /* Color del título */
}

form {
    width: 100%; /* Asegura que el formulario ocupe todo el ancho del contenedor */
    max-width: 600px; /* Ancho máximo del formulario */
    flex-grow: 1; /* Permite que el formulario ocupe el espacio disponible */
}

.form-group {
    margin-bottom: 15px; /* Espaciado entre grupos de formulario */
}

.form-group label {
    background-color: rgba(255, 255, 255, 0.8);
    padding: 5px;
    border-radius: 5px;
    color: #333;
}

.form-group input,
.form-group textarea {
    background-color: rgba(255, 255, 255, 0.9);
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    width: 100%; /* Ancho completo */
}

.btn-container {
    display: flex;
    justify-content: space-between; 
    width: 100%;
    margin-top: 20px;
}

.image-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    width: 100%;
    flex-wrap: wrap;
}

.image-container img {
    max-width: 150px; /* Tamaño deseado para las imágenes */
    height: auto; 
    margin: 5px;
}
</style>

<div class="main-container">
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
            <label for="categoria_id">Categoría <span class="text-danger">*</span></label>
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
        <!-- Mostrar imágenes existentes -->
        <div class="form-group">
                    <label>Imágenes actuales:</label>
                    <div class="row">
                        @foreach ($producto->imagenes as $imagen)
                            <div class="col-md-3">
                                <img src="{{ Storage::url($imagen->path) }}" class="img-fluid" alt="Imagen del producto">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="delete_images[]" value="{{ $imagen->id }}">
                                    <label class="form-check-label">Eliminar</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
        <!-- Subir nuevas imágenes -->
        <div class="form-group">
            <label for="imagenes">Subir Nuevas Imágenes:</label>
            <input type="file" class="form-control" name="imagenes[]" multiple>
        </div>
        <!-- Botones de Actualizar y Cancelar -->
        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Volver al Dashboard</a>
            <a href="{{ route('productos.index') }}" class="btn btn-danger">Cancelar</a>
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
