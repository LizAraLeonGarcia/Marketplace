@extends('layouts.app')

@section('content')

<style>
    body {
        margin: 0;
        height: 100vh; /* Altura de la ventana */
        background-image: url('{{ asset('img/fondoFormCreate.jpg') }}');
        background-size: cover; /* La imagen cubre toda la pantalla */
        background-position: center; /* Centra la imagen */
        background-repeat: no-repeat; /* No repetir la imagen */
    }

    .form-container {
        padding: 40px;
        border-radius: 15px; 
        background: transparent; /* Cambia a 'transparent' para quitar el fondo */
        max-width: 600px; /* Limitar el ancho del formulario */
        margin: auto; /* Centrar el formulario en la página */
        position: relative; /* Cambia a posición relativa si quieres que se coloque dentro del flujo del documento */
        top: 20%; /* Opcional: ajustar la posición vertical */
        box-shadow: none; /* Eliminar cualquier sombra */
    }

    h1 {
        text-align: center; /* Centrar el título */
        color: white; /* Color del texto, puedes ajustarlo según el fondo */
    }

    .form-group {
        margin-bottom: 20px; /* Espacio entre los campos */
    }

    img {
        max-width: 100%; /* Asegura que las imágenes se ajusten a su contenedor */
        height: auto; /* Mantiene la relación de aspecto */
    }
</style>

<div class="container-fluid">
    <div class="form-container">
        <h1 class="mb-4">Crear Producto</h1>
        
        <!-- Formulario -->
        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Nombre del producto -->
            <div class="form-group">
                <label for="nombre">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" placeholder="Introduce el nombre del producto" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Descripción del producto -->
            <div class="form-group">
                <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Descripción del producto" rows="4" required>{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Precio del producto -->
            <div class="form-group">
                <label for="precio">Precio <span class="text-danger">*</span></label>
                <input type="number" name="precio" id="precio" class="form-control @error('precio') is-invalid @enderror" placeholder="Ejemplo: 19.99" value="{{ old('precio') }}" required step="0.01">
                @error('precio')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Stock del Producto -->
            <div class="form-group">
                <label for="stock">Stock <span class="text-danger">*</span></label>
                <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" placeholder="Cantidad en inventario" value="{{ old('stock') }}" required>
                @error('stock')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Categoría del producto -->
            <div class="form-group">
                <label for="categoria_id">Categoría <span class="text-danger">*</span></label>
                <select name="categoria_id" id="categoria_id" class="form-control @error('categoria_id') is-invalid @enderror" required>
                    <option value="">Seleccionar categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
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
                <label for="imagen">Imagen del Producto <span class="text-danger">*</span></label>
                <input type="file" name="imagen" id="imagen" class="form-control @error('imagen') is-invalid @enderror" accept="image/*" required onchange="previewImage(event)">
                @error('imagen')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <img id="preview" src="#" alt="Vista previa de la imagen" style="max-width: 200px; margin-top: 10px; display: none;">
            </div>

            <!-- Botón de Enviar -->
            <div class="text-center">
                <button type="submit" class="btn btn-success" style="width: 200px;" onclick="this.disabled=true; this.form.submit();">Crear Producto</button>
            </div>
        </form>

        <!-- Espacio para imágenes debajo del formulario -->
        <div class="row mt-5">
            <div class="col-md-4">
                <img src="{{ asset('img/crear1.png') }}" alt="Imagen 1" class="img-fluid rounded">
            </div>
            <div class="col-md-4">
                <img src="{{ asset('img/crear2.png') }}" alt="Imagen 2" class="img-fluid rounded">
            </div>
            <div class="col-md-4">
                <img src="{{ asset('img/crear3.png') }}" alt="Imagen 3" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection
