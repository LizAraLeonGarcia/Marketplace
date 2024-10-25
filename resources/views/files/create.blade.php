@extends('layouts.app')  <!-- Asegúrate de que extiendas tu diseño base -->

@section('content')
    <h1>Cargar Archivos</h1>

    <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="files[]" multiple>
        <button type="submit">Cargar Archivos</button>
    </form>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
@endsection
