<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ProductCreated;
use Illuminate\Support\Facades\Gate;

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
            ? Producto::where('categoria_id', $request->categoria_id)->paginate(10)
            : Producto::paginate(10); 
        
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
            'imagenes' => 'required_without:imagenes.*|array', // Al menos una imagen
            'imagenes.*' => 'image|mimes:jpg,png,jpeg|max:2048',
        ]);
    
        // Crear el producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
            'user_id' => auth()->id(),
            'vendedor_id' => auth()->id(),
        ]);
    
        // Manejar la subida de imágenes
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $image) {
                $path = $image->store('products', 'public');
                $producto->imagenes()->create(['path' => $path]); // Guarda la ruta de la imagen
            }
        }
    
        // Actualizar el estado de vendedor si es necesario
        if (!Auth::user()->is_vendedor) {
            Auth::user()->is_vendedor = true;
            Auth::user()->save();
        }
    
        // Enviar la notificación al usuario
        $request->user()->notify(new ProductCreated($producto));
    
        // Redirigir al índice de productos con mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto creado con éxito.');        
    }    

    public function show(Producto $producto)
    {
        $producto->load('imagenes');
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        if (Gate::denies('update', $producto)) {
            return redirect()->route('productos.index')->with('error', 'No tienes permiso para editar este producto.');
        }
        
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
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
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
                $imagen = Image::find($imageId);
                if ($imagen) {
                    Storage::disk('public')->delete($imagen->path);
                    $imagen->delete();
                }
            }
        }
        // Subir nuevas imágenes
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $path = $imagen->store('imagenes', 'public');
                $producto->imagenes()->create(['path' => $path]); // Cambiado a 'path'
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }

    public function destroy(Producto $producto)
    {
        if (Gate::denies('delete', $producto)) {
            return redirect()->route('productos.index')->with('error', 'No tienes permiso para eliminar este producto.');
        }

        foreach ($producto->imagenes as $imagen) {
            Storage::disk('public')->delete($imagen->path); 
            $imagen->delete();
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
    //
    
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
