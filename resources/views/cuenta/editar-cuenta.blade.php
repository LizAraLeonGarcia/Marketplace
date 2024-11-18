@extends('layouts.app')

@section('title', 'Editar cuenta')

@section('content')

    @if (session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif

    <div class="editarCuenta">
        <div class="image-container">
            <img src="{{ asset('assets/img/editarCuenta.png') }}" alt="Descripción de la imagen" class="img-fluid">
        </div>    
        <!-- Formulario -->
        <div class="formCuenta">
            <h1 class="mb-4 text-center textos">Editar cuenta</h1>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('cuenta.actualizar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h2 class="mb-4 text-center textos">Información personal</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-cuentaEditar">
                            <label for="nombre" class="textos">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" id="nombre" class="form-control" 
                                placeholder="Ingresa tu nombre" 
                                value="{{ old('nombre', $user->nombre) }}" required>
                            @error('nombre') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-cuentaEditar">
                            <label for="apellido" class="textos">Apellido <span class="text-danger">*</span></label>
                            <input type="text" name="apellido" id="apellido" class="form-control" 
                                placeholder="Ingresa tu apellido" 
                                value="{{ old('apellido', $user->apellido) }}" required>
                            @error('apellido') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-cuentaEditar">
                            <label for="apodo" class="textos">Apodo</label>
                            <input type="text" name="apodo" id="apodo" class="form-control" 
                                placeholder="Ingresa tu apodo" 
                                value="{{ old('apodo', $user->apodo) }}">
                            @error('apodo') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="foto" class="textos">Foto <span class="text-danger">*</span></label>
                        <label for="profile_imagen" class="textos">Selecciona una imagen de perfil predeterminada o sube una propia</label> 
                        <!-- Carrusel de imágenes de perfil -->
                        <div id="profileCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @php
                                    $imagesPerSlide = 3;  
                                    $chunks = array_chunk($defaultProfileImages, $imagesPerSlide);
                                @endphp

                                @foreach($chunks as $index => $chunk)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <div class="d-flex justify-content-between">
                                            @foreach($chunk as $image)
                                                <div class="position-relative text-center mx-2">
                                                    <img src="{{ asset('img/imagenesPerfil/' . $image) }}" class="profile-preview" alt="Imagen de perfil">
                                                    <!-- Checkbox de tipo radio para seleccionar la imagen de perfil -->
                                                    <div class="form-check mt-2">
                                                        <input type="radio" name="foto" value="{{ 'img/imagenesPerfil/' . $image }}" class="form-check-input"
                                                        {{ old('foto', $user->foto) === 'img/imagenesPerfil/' . $image ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Controles de navegación -->
                            <a class="carousel-control-prev" href="#profileCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Anterior</span>
                            </a>
                            <a class="carousel-control-next" href="#profileCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Siguiente</span>
                            </a>
                        </div>
                        <!-- Formulario para subir la foto personalizada -->
                        <div class="form-cuentaEditar mt-3">
                            <input type="file" name="foto_personalizada" id="foto_personalizada" class="form-control" accept="image/*">
                            @error('foto_personalizada') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div> 
                    </div>
                </div>
                <h2 class="mb-4 text-center textos">Información Adicional</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-cuentaEditar">
                            <label for="sexo" class="textos">Sexo <span class="text-danger">*</span></label>
                            <select name="sexo" id="sexo" class="form-control" required>
                                <option value="">Selecciona</option>
                                <option value="Femenino" {{ (old('sexo', $user->sexo) == 'Femenino') ? 'selected' : '' }}>Femenino</option>
                                <option value="Masculino" {{ (old('sexo', $user->sexo) == 'Masculino') ? 'selected' : '' }}>Masculino</option>
                            </select>
                            @error('sexo') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-cuentaEditar">
                            <label for="pais" class="textos">País <span class="text-danger">*</span></label>
                                <select name="pais_id" id="pais" class="form-control" required>
                                    @foreach($paises as $pais)
                                        <option value="{{ $pais->id }}" {{ old('pais_id', $user->pais_id) == $pais->id ? 'selected' : '' }}>{{ $pais->nombre }}</option>
                                    @endforeach
                                </select>
                            @error('pais_id') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-cuentaEditar">
                            <label for="fecha_nacimiento" class="textos">Fecha de Nacimiento <span class="text-danger">*</span></label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" 
                                value="{{ old('fecha_nacimiento', is_string($user->fecha_nacimiento) ? $user->fecha_nacimiento : ($user->fecha_nacimiento ? $user->fecha_nacimiento->format('Y-m-d') : '')) }}" required>    
                            @error('fecha_nacimiento') 
                            <div class="alert alert-danger">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-cuentaEditar">
                        <label for="descripcion" class="textos">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" 
                            placeholder="Escribe una breve descripción sobre ti">{{ old('descripcion', $user->descripcion) }}</textarea>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-actualizarCuenta mb-4">Actualizar</button>
            </form>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carousel = document.querySelector('#profileCarousel');
        carousel.addEventListener('slid.bs.carousel', function () {
            const activeItem = carousel.querySelector('.carousel-item.active img');
            const selectedImage = activeItem.getAttribute('src');
            // Asigna la imagen seleccionada al campo oculto
            document.querySelector('#selectedProfileImage').value = selectedImage;
        });
    });
</script>
@endsection
