@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Producto</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('productos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre del Producto</label>
                <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}">
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" name="descripcion">{{ old('descripcion') }}</textarea>
            </div>

            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" class="form-control" name="precio" value="{{ old('precio') }}" step="0.01">
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" class="form-control" name="cantidad" value="{{ old('cantidad') }}">
            </div>

            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
@endsection