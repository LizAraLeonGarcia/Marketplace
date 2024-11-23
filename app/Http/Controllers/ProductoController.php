<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Image;
use App\Mail\PrimerProductoMail;
use App\Notifications\ProductCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']); 
    }
    // ********************************************************** todos los productos **********************************************************
    public function index(Request $request)
    {
        $categorias = Categoria::all();
        // Obtener el filtro de categoría si existe
        $categoriaId = $request->get('categoria_id');
        // Consultar los productos, aplicando el filtro si corresponde
        $productos = Producto::with(['categoria', 'images']) // eager loading
            ->when($categoriaId, function ($query) use ($categoriaId) {
                return $query->where('categoria_id', $categoriaId);
            })
            ->paginate(12)
            ->appends($request->all()); // Agregar parámetros a la paginación

        return view('productos.index', compact('productos', 'categorias', 'categoriaId'));
    }
    // ***************************************************************** crear *****************************************************************
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }
    // ***************************************************************** store *****************************************************************
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|min:10|max:700',
            'precio' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:1',
            'categoria_id' => 'required|exists:categorias,id',
            'images' => 'required|array|max:10', 
            'images.*' => 'image|mimes:jpg,png,jpeg|max:2048',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria y debe tener al menos 10 caracteres.',
            'precio.required' => 'El precio es obligatorio y debe ser un valor numérico.',
            'stock.required' => 'El stock es obligatorio y debe ser un número entero.',
            'categoria_id.required' => 'Debes seleccionar una categoría.',
            'images.required' => 'Es necesario subir al menos una imagen del producto.',
            'images.array' => 'Debes subir una serie de imágenes.',
            'images.max' => 'No puedes subir más de 10 imágenes.',
            'images.*.image' => 'Cada archivo debe ser una imagen y máximo puedes subir 10 imágenes.',
            'images.*.mimes' => 'Las imágenes deben ser en formato jpg, png o jpeg.',
            'images.*.max' => 'Cada imagen no debe superar los 2 MB.',
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
        return redirect()->route('dashboard')->with('success', 'Producto creado con éxito.');        
    }    
    // **************************************************************** mostrar ****************************************************************
    public function show(Producto $producto)
    {
        $producto->load(['images', 'categoria']);
        return view('productos.show', compact('producto'));
    }
    // ***************************************************************** edita *****************************************************************
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
    // *************************************************************** actualiza ***************************************************************
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
        // Actualizar producto
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

        return redirect()->route('dashboard')->with('success', 'Producto actualizado con éxito.');
    }
    // *********************************************************** eliminar producto ***********************************************************
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
        
        return redirect()->route('dashboard')->with('success', 'Producto eliminado exitosamente.');
    }
    // ********************************************************* filtrar los productos *********************************************************
    // .......................................................................................................................... por categoria
    public function porCategoria($id)
    {
        // Obtener el filtro de categoría desde el request
        $categoria_id = $request->input('categoria_id');
        // Obtener los productos, aplicando el filtro si corresponde
        $query = Producto::query();
        if ($categoria_id) {
            $query->where('categoria_id', $categoria_id);
        }
        // Paginación
        $productos = $query->paginate(12)->appends($request->all());
        // Obtener todas las categorías para el select
        $categorias = Categoria::all();

        return view('productos.index', compact('productos', 'categorias', 'categoria_id'));
    }
    // ............................................................................................................................mas vendidos
    // ........................................................................................................................ recomendaciones
    // ................................................................................................................................ ofertas
    // ....................................................................................................................... nuevos productos
    public function nuevosProductos()
    {
        $productos = Producto::where('created_at', '>=', now()->subMonth())->get();
        return view('productos.index', compact('productos'));
    }
    // ............................................................................................................................. por precio
    // Filtrar por rango de precios
    public function porPrecio(Request $request)
    {
        // Obtener los valores de precio desde la solicitud
        $minPrecio = $request->input('min_precio');
        $maxPrecio = $request->input('max_precio');

        // Filtrar productos según el rango de precio
        $productos = Producto::when($minPrecio, function ($query) use ($minPrecio) {
                return $query->where('precio', '>=', $minPrecio);  // Filtra el precio mínimo
            })
            ->when($maxPrecio, function ($query) use ($maxPrecio) {
                return $query->where('precio', '<=', $maxPrecio);  // Filtra el precio máximo
            })
            ->paginate(12)
            ->appends($request->all());  // Asegura que los parámetros se mantengan en la paginación

        // Obtener todas las categorías para pasarlas a la vista
        $categorias = Categoria::all();

        return view('productos.index', compact('productos', 'categorias', 'minPrecio', 'maxPrecio'));
    }
    // ................................................................................................................................. buscar
    public function buscar(Request $request)
    {
        // Verifica el parámetro de búsqueda
        $query = $request->input('query');
        if (!$query) {
            // Si no hay consulta, puedes devolver un error o redirigir
            return redirect()->route('productos.index')->with('error', 'No se proporcionó un término de búsqueda.');
        }
        // Intentamos hacer la consulta en la base de datos
        try {
            // Recuperamos los productos basados en la búsqueda
            $productos = Producto::where('nombre', 'like', "%$query%")
                ->orWhere('descripcion', 'like', "%$query%")
                ->paginate(12) // 12 productos máximo por página
                ->appends(['query' => $query]);  // Agregar el parámetro 'query' a la paginación
            // Recuperamos las categorías disponibles para pasar a la vista
            $categorias = Categoria::all();  // Suponiendo que tienes un modelo Categoria
        } catch (\Exception $e) {
            // Capturamos cualquier error que ocurra durante la consulta
            return response()->json(['error' => 'Hubo un problema al procesar la búsqueda.'], 500);
        }
        // Retornamos los productos y las categorías encontradas a la vista
        return view('productos.index', compact('productos', 'query', 'categorias'));
    }
    // -------------------------------------------------------------- categorias --------------------------------------------------------------
    public function categoria($categoria)
    {
        $productos = Producto::where('categoria_id', $categoria)->paginate(10);
        return view('productos.categoria', compact('productos', 'categoria'));
    }
    // --------------------------------------------------------------- dashboard ---------------------------------------------------------------
    public function dashboard()
    {
        $user = auth()->user();
        $productos = Producto::where('user_id', $user->id)->paginate(10);
        $categorias = Categoria::all();
        return view('dashboard', compact('productos', 'categorias'));
    }
}
