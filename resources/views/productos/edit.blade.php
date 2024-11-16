@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')

    <div class="productEdit">
        <div class="contenidoProductEdit">
            <h2 class="text-center">Editar Producto</h2>
            <h4 class="text-center">Recuerda que todos los campos son obligatorios.</h4>
            <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- nombre ------------------------------------------------------------------------------------------------------------------------ -->
                <div class="form-Edit">
                    <label for="nombre">Nombre <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $producto->nombre) }}" required>
                    @error('nombre')
                        <div class="alert alert-danger" style="background-color: rgba(255, 0, 0, 0.1); padding: 5px; border-radius: 5px;">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                    @enderror
                </div>
                <!-- descripción ------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-Edit">
                    <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                    <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="alert alert-danger" style="background-color: rgba(255, 0, 0, 0.1); padding: 5px; border-radius: 5px;">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                    @enderror
                </div>
                <!-- precio ------------------------------------------------------------------------------------------------------------------------ -->
                <div class="form-Edit">
                    <label for="precio">Precio ($) <span class="text-danger">*</span></label>
                    <input type="number" name="precio" id="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio', $producto->precio) }}" step="0.01" required>
                    @error('precio')
                        <div class="alert alert-danger" style="background-color: rgba(255, 0, 0, 0.1); padding: 5px; border-radius: 5px;">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                    @enderror
                </div>
                <!-- stock ------------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-Edit">
                    <label for="stock">Stock <span class="text-danger">*</span></label>
                    <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $producto->stock) }}" required>
                    @error('stock')
                        <div class="alert alert-danger" style="background-color: rgba(255, 0, 0, 0.1); padding: 5px; border-radius: 5px;">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                    @enderror
                </div>
                <!-- categorías -------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-Edit">
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
                        <div class="alert alert-danger" style="background-color: rgba(255, 0, 0, 0.1); padding: 5px; border-radius: 5px;">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                    @enderror
                </div>
                <!-- mostrar imágenes existentes --------------------------------------------------------------------------------------------------- -->
                <div class="form-Edit">
                    <label>Imágenes actuales:</label>
                    <div class="row">
                        @if($producto->images && $producto->images->isNotEmpty())
                            @foreach ($producto->images as $image)
                                <div class="col-md-3">
                                    <img src="{{ Storage::url($image->path) }}" class="img-fluid" alt="Imagen del producto">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="delete_images[]" value="{{ $image->id }}">
                                        <label class="form-check-label">Eliminar</label>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No hay imágenes disponibles para este producto.</p>
                        @endif
                    </div>
                </div>
                <!-- subir nuevas imágenes --------------------------------------------------------------------------------------------------------- -->
                <div class="form-Edit">
                    <label for="images">Subir nuevas imágenes:</label>
                    <input type="file" class="form-control" name="images[]" multiple>
                </div>
                <!-- ----------------------------------------------------------- botones ----------------------------------------------------------- -->
                <div class="btn-container">
                    <button type="submit" class="btn btn-actualizar">Actualizar</button>
                    <a href="{{ route('productos.index') }}" class="btn btn-cancelar">Cancelar</a>
                </div>
            </form>
                
            @if (Auth::user()->can('delete', $producto))
                <div class="delete-btn-container">
                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar producto</button>
                    </form>
                </div>
            @endif
            <!-- ------------------------------------------------------- sección de imágenes ------------------------------------------------------- -->
            <div class="image-container">
                <img src="{{ asset('img/editar1.png') }}" alt="Imagen 1">
                <img src="{{ asset('img/editar2.png') }}" alt="Imagen 2">
                <img src="{{ asset('img/editar3.png') }}" alt="Imagen 3">
            </div>
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
