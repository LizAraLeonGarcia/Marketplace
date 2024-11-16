@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')

    <div class="productCreate">
        <div class="contenidoProductCreate">
            <h1 class="text-center">Crear un producto</h1>
            <h3 class="text-center">Todos los campos son obligatorios</h3>
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- nombre -------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-create">
                    <label for="nombre">Nombre <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" placeholder="Introduce el nombre del producto" value="{{ old('nombre') }}" required minlength="2" maxlength="100">
                    @error('nombre')
                        <div class="alert alert-danger" style="background-color: rgba(255, 0, 0, 0.1); padding: 5px; border-radius: 5px;">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                    @enderror
                </div>
                <!-- descripción --------------------------------------------------------------------------------------------------------------- -->
                <div class="form-create">
                    <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                    <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Descripción del producto" rows="4" required minlength="10" maxlength="500">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="alert alert-danger" style="background-color: rgba(255, 0, 0, 0.1); padding: 5px; border-radius: 5px;">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                    @enderror
                </div>
                <!-- precio -------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-create">
                    <label for="precio">Precio <span class="text-danger">*</span></label>
                    <input type="number" name="precio" id="precio" class="form-control @error('precio') is-invalid @enderror" placeholder="Ejemplo: 19.99" value="{{ old('precio') }}" required step="0.01" min="1">
                    @error('precio')
                        <div class="alert alert-danger" style="background-color: rgba(255, 0, 0, 0.1); padding: 5px; border-radius: 5px;">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                    @enderror
                </div>
                <!-- stock --------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-create">
                    <label for="stock">Stock <span class="text-danger">*</span></label>
                    <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" placeholder="Cantidad en inventario" value="{{ old('stock') }}" required min="1">
                    @error('stock')
                        <div class="alert alert-danger" style="background-color: rgba(255, 0, 0, 0.1); padding: 5px; border-radius: 5px;">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                    @enderror
                </div>
                <!-- categorias ---------------------------------------------------------------------------------------------------------------- -->
                <div class="form-create">
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
                        <div class="alert alert-danger" style="background-color: rgba(255, 0, 0, 0.1); padding: 5px; border-radius: 5px;">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                    @enderror
                </div>
                <!-- imagenes ------------------------------------------------------------------------------------------------------------------ -->
                <div class="form-create">
                    <label for="images">Imágenes del Producto <span class="text-danger">*</span></label>
                    <input type="file" name="images[]" id="images" class="form-control @error('images') is-invalid @enderror" accept="image/*" required multiple onchange="previewImages(event)">
                    @error('images')
                        <div class="alert alert-danger" style="background-color: rgba(255, 0, 0, 0.1); padding: 5px; border-radius: 5px;">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                    @enderror
                    @error('images.*')
                        <div class="alert alert-danger" style="background-color: rgba(255, 0, 0, 0.1); padding: 5px; border-radius: 5px;">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                    @enderror
                    <div id="preview-container" style="margin-top: 10px;"><!-- Las imágenes de vista previa se insertarán aquí --></div>
                </div>
                <!-- --------------------------------------------------------- botones --------------------------------------------------------- -->
                <div class="text-center">
                    <button type="submit" class="btn btn-crear" onclick="this.disabled=true; this.form.submit();">Crear Producto</button>
                    <a href="{{ route('productos.index') }}" class="btn btn-cancelarCreacion">Cancelar</a>
                </div>
            </form>
            <!-- ------------------------------------------------ sección de imáegnes de adorno ------------------------------------------------ -->
            <div class="image-container">
                <img src="{{ asset('img/crear1.png') }}" alt="Imagen 1" class="img-fluid rounded">
                <img src="{{ asset('img/crear2.png') }}" alt="Imagen 2" class="img-fluid rounded">
                <img src="{{ asset('img/crear3.png') }}" alt="Imagen 3" class="img-fluid rounded">
            </div>
        </div>
    </div>

<script>
    const MAX_IMAGES = 10; // Establece un límite de 10 imágenes

    function previewImages(event) {
        const previewContainer = document.getElementById('preview-container');
        previewContainer.innerHTML = '';
        
        const files = event.target.files;
        if (files.length > MAX_IMAGES) {
            alert(`Solo puedes subir hasta ${MAX_IMAGES} images`);
            event.target.value = ''; // Limpiar la selección de imágenes
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '200px';
                img.style.marginRight = '10px';
                img.style.marginTop = '10px';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
