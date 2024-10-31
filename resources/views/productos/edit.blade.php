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
        height: 100%;
        display: flex;
        flex-direction: column; 
        justify-content: flex-start; 
        align-items: center; 
        padding: 20px; 
    }

    h2 {
        margin: 10px 0; 
        color: #f39c12; 
    }

    h4 {
        margin: 10px 0; 
        color: #f39c12; 
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 5px;
    }

    form {
        width: 100%;
        max-width: 600px; 
        flex-grow: 1; 
    }

    .form-group {
        margin-bottom: 15px; 
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
        width: 100%; 
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
        max-width: 150px; 
        height: auto; 
        margin: 5px;
    }

    .text-danger {
        color: red; /* Color del asterisco rojo */
    }

    .delete-btn-container {
        display: flex;
        justify-content: center; /* Centra el botón de eliminación horizontalmente */
        margin-top: 20px; /* Espacio superior para separación */
    }
</style>

<div class="main-container">
    <h2 class="text-center">Editar Producto</h2>
    <h4 class="text-center">Recuerda que todos los campos son obligatorios.</h4>

    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Nombre del Producto -->
        <div class="form-group">
            <label for="nombre">Nombre <span class="text-danger">*</span></label>
            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $producto->nombre) }}" required>
            @error('nombre')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <!-- Descripción del Producto -->
        <div class="form-group">
            <label for="descripcion">Descripción <span class="text-danger">*</span></label>
            <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
            @error('descripcion')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <!-- Precio del Producto -->
        <div class="form-group">
            <label for="precio">Precio ($) <span class="text-danger">*</span></label>
            <input type="number" name="precio" id="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio', $producto->precio) }}" step="0.01" required>
            @error('precio')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <!-- Stock del Producto -->
        <div class="form-group">
            <label for="stock">Stock <span class="text-danger">*</span></label>
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
                @if($producto->images && $producto->images->isNotEmpty())
                    @foreach ($producto->images as $imagen)
                        <div class="col-md-3">
                            <img src="{{ Storage::url($imagen->path) }}" class="img-fluid" alt="Imagen del producto">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="delete_images[]" value="{{ $imagen->id }}">
                                <label class="form-check-label">Eliminar</label>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No hay imágenes disponibles para este producto.</p>
                @endif
            </div>
        </div>
        <!-- Subir nuevas imágenes -->
        <div class="form-group">
            <label for="images">Subir nuevas imágenes:</label>
            <input type="file" class="form-control" name="images[]" multiple>
        </div>
        <!-- Botones de Actualizar y Cancelar -->
        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Volver al Dashboard</a>
            <a href="{{ route('productos.index') }}" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
        
    @if (Auth::user()->can('delete', $producto))
        <div class="delete-btn-container">
            <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    @endif
    <!-- Sección de Imágenes -->
    <div class="image-container">
        <img src="{{ asset('img/editar1.png') }}" alt="Imagen 1">
        <img src="{{ asset('img/editar2.png') }}" alt="Imagen 2">
        <img src="{{ asset('img/editar3.png') }}" alt="Imagen 3">
    </div>
    <script>

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form');
        form.addEventListener('submit', (event) => {
            const precio = document.getElementById('precio');
            const stock = document.getElementById('stock');       
            // Validación personalizada
            if (precio.value <= 0) {
                event.preventDefault();
                alert('El precio debe ser mayor que 0');
                precio.focus();
            }

            if (stock.value < 0) {
                event.preventDefault();
                alert('El stock no puede ser negativo');
                stock.focus();
            }
        });
    });
    </script>
</div>
@endsection
