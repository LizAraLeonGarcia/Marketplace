<?php

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    // Método para cargar archivos (si no lo tienes, añade este método)
    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        foreach ($request->file('files') as $file) {
            $path = $file->store('uploads', 'public');
            File::create(['name' => $file->getClientOriginalName(), 'path' => $path]);
        }

        return redirect()->back()->with('success', 'Archivos cargados correctamente.');
    }

    // Método para listar archivos
    public function index()
    {
        $files = File::all();
        return view('files.index', compact('files'));
    }

    // Método para eliminar archivos
    public function destroy($id)
    {
        $file = File::findOrFail($id);
        Storage::disk('public')->delete($file->path);
        $file->delete();

        return redirect()->back()->with('success', 'Archivo eliminado correctamente.');
    }

    // Método para reemplazar archivos
    public function update(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $file = File::findOrFail($id);
        Storage::disk('public')->delete($file->path);
        $newFile = $request->file('file');
        $path = $newFile->store('uploads', 'public');
        $file->update(['name' => $newFile->getClientOriginalName(), 'path' => $path]);

        return redirect()->back()->with('success', 'Archivo reemplazado correctamente.');
    }
}
