@extends('layouts.app')

@section('title', 'Editar cuenta')

@section('content')

    @if (session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif
    <!-- Contenido principal -->
    <div id="main-content" class="container mt-4">
        <div class="row">
            <div class="col-md-4 d-flex align-items-end">
                <img src="{{ asset('assets/img/editarCuenta.png') }}" alt="Descripción de la imagen" class="img-fluid">
            </div>
            <div class="col-md-8">
                <h1 class="mb-4 text-center textos">Editar cuenta</h1>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('perfil.actualizar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h2 class="mb-4 text-center textos">Información personal</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre" class="textos">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" id="nombre" class="form-control" 
                                    placeholder="Ingresa tu nombre" 
                                    value="{{ old('nombre', $user->nombre) }}" required>
                                @error('nombre') <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellido" class="textos">Apellido <span class="text-danger">*</span></label>
                                <input type="text" name="apellido" id="apellido" class="form-control" 
                                    placeholder="Ingresa tu apellido" 
                                    value="{{ old('apellido', $user->apellido) }}" required>
                                @error('apellido') <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apodo" class="textos">Apodo</label>
                                <input type="text" name="apodo" id="apodo" class="form-control" 
                                    placeholder="Ingresa tu apodo" 
                                    value="{{ old('apodo', $user->apodo) }}">
                                @error('apodo') <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto" class="textos">Foto <span class="text-danger">*</span></label>
                                <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                                @error('foto') <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <h2 class="mb-4 text-center textos">Información Adicional</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
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
                            <div class="form-group">
                                <label for="pais" class="textos">País <span class="text-danger">*</span></label>
                                <select name="pais_id" id="pais" class="form-control" required>
                                    @foreach($paises as $pais)
                                        <option value="{{ $pais->id }}" {{ old('pais_id', $user->pais_id) == $pais->id ? 'selected' : '' }}>{{ $pais->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('pais') <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_nacimiento" class="textos">Fecha de Nacimiento <span class="text-danger">*</span></label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" 
                                    value="{{ old('fecha_nacimiento', is_string($user->fecha_nacimiento) ? $user->fecha_nacimiento : ($user->fecha_nacimiento ? $user->fecha_nacimiento->format('Y-m-d') : '')) }}" required>    
                                @error('fecha_nacimiento') 
                                    <div class="alert alert-danger">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
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

                    <button type="submit" class="btn btn-primary mb-4">Actualizar Cuenta</button>
                </form>
            </div>
        </div>
    </div>
@endsection
