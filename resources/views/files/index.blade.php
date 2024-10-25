@extends('layouts.app')

@section('content')
    <h1>Listado de Archivos</h1>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @foreach($files as $file)
    <div>
        <span>{{ $file->name }}</span>
        <a href="{{ asset('storage/' . $file->path) }}" download>Descargar</a>
        
        <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este archivo?');">Eliminar</button>
        </form>
        
        <form action="{{ route('files.update', $file->id) }}" method="POST" enctype="multipart/form-data" style="display:inline;">
            @csrf
            @method('PUT')
            <input type="file" name="file" required>
            <button type="submit">Reemplazar</button>
        </form>
    </div>
    @endforeach
@endsection
