<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Mail\PrimerProductoMail;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ProductCreated;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']); 
    }

    public function index(Request $request)
    {
        $categorias = Categoria::all();
        $productos = $request->has('categoria_id') && $request->categoria_id != null
            ? Producto::with(['categoria', 'images']) // eager loading
                ->where('categoria_id', $request->categoria_id)
                ->paginate(10)
            : Producto::with(['categoria', 'images']) // eager loading
                ->paginate(10);     
                
        return view('productos.index', compact('productos', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
            'images' => 'array', 
            'images.*' => 'image|mimes:jpg,png,jpeg|max:2048',
        ]);
        // Crear el producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
            'user_id' => auth()->id(),
        ]);
        // Manejar la subida de imágenes
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $producto->images()->create(['path' => $path]); // Guarda la ruta de la imagen
            }
        }
        // Verificar si es el primer producto del usuario
        if (auth()->user()->productos()->count() === 1) {
            // Notificar al usuario solo si es su primer producto
            $producto->user->notify(new ProductCreated($producto)); // Pasa el objeto Producto aquí
        }
        // Actualizar el estado de vendedor si es necesario
        if (!Auth::user()->is_vendedor) {
            Auth::user()->is_vendedor = true;
            Auth::user()->save();
        }
        // Redirigir al índice de productos con mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto creado con éxito.');        
    }    

    public function show(Producto $producto)
    {
        $producto->load(['images', 'categoria']);
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        if (Gate::denies('update', $producto)) {
            return redirect()->route('productos.index')->with('error', 'No tienes permiso para editar este producto.');
        }
        // Cargar la relación de imágenes
        $producto->load('images');
        $categorias = Categoria::all();

        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
            'images' => 'array', 
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
        ]);
        // Eliminar imágenes seleccionadas
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = Image::find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
        }
        // Subir nuevas imágenes
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('producto', 'public');
                $producto->images()->create(['path' => $path]); 
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }

    public function destroy(Producto $producto)
    {
        if (Gate::denies('delete', $producto)) {
            return redirect()->route('productos.index')->with('error', 'No tienes permiso para eliminar este producto.');
        }
        // eliminar imagenes asociadas
        foreach ($producto->images as $image) {
            Storage::disk('public')->delete($image->path); 
            $image->delete();
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
    //
    public function categoria($categoria)
    {
        $productos = Producto::where('categoria_id', $categoria)->paginate(10);
        return view('productos.categoria', compact('productos', 'categoria'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        $productos = Producto::where('user_id', $user->id)->paginate(10);
        $categorias = Categoria::all();
        return view('dashboard', compact('productos', 'categorias'));
    }
}
