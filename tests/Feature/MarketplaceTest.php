<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User; // Modelo User
use App\Models\Categoria; // Modelo Categoria
use App\Models\Producto; // Modelo Producto
use App\Models\Image; // Modelo Imagen
use Tests\TestCase;

class MarketplaceTest extends TestCase
{
    use RefreshDatabase;// Esto limpiará y recreará la base de datos en cada prueba.

    protected function setUp(): void
    {
        parent::setUp();
        // Ejecutar solo el seeder de Categorías
        $this->seed(\Database\Seeders\CategoriaSeeder::class);
    }
    // *************************************************************** TEST UNO ***************************************************************
    public function test_authenticated_user_sees_dashboard_with_message()
    {
        $user = User::factory()->create(); // Crear un usuario de prueba
        $response = $this->actingAs($user)->get('/dashboard'); // Simular inicio de sesión y acceso
        $response->assertStatus(200); // Verificar que la respuesta es 200
        $response->assertSee('¡Hola, ' . $user->name . '!'); // Verificar que el saludo con el nombre del usuario esté presente
    }
    // *************************************************************** TEST DOS ***************************************************************
    public function test_product_creation_creates_record_and_redirects()
    {
        // Crear un usuario autenticado
        $user = User::factory()->create(); 
        $this->actingAs($user);
        // Usar disco 'test' para evitar renombrar la imagen (si usas una configuración específica)
        Storage::disk('test')->put('products/test-image.jpg', file_get_contents(storage_path('app/public/test-image.jpg')));
        // Crear el producto con datos de prueba
        $response = $this->post(route('productos.store'), [
            'nombre' => 'MK 11 ULTIMATE',
            'descripcion' => 'Juego de pelea con todos los personajes y contenido adicional',
            'precio' => 100,
            'stock' => 10,
            'categoria_id' => Categoria::first()->id,
            'images' => [
                new \Illuminate\Http\UploadedFile(
                    storage_path('app/test/products/test-image.jpg'),
                    'test-image.jpg',
                    'image/jpeg',
                    null,
                    true
                ),
            ],
        ]);
        // Verificar que el producto fue creado
        $this->assertDatabaseHas('productos', [
            'nombre' => 'MK 11 ULTIMATE',
            'precio' => 100,
        ]);
        // Verificar la redirección
        $response->assertRedirect(route('dashboard'));
        // Verificar que la imagen se haya guardado correctamente en el almacenamiento
        $product = Producto::latest()->first();
        // Obtener el path de la imagen almacenada
        $imagePath = 'products/' . basename($product->image);
        // Ajustar la comparación para verificar solo el prefijo del path
        $this->assertStringStartsWith('products/', $imagePath); // Verifica que el path comience con 'products/'
        // Verificar que el archivo de imagen realmente existe en el almacenamiento
        $this->assertTrue(Storage::disk('public')->exists($imagePath)); // O el disco que estés usando
    }
    // ************************************************************** TEST TRES ***************************************************************
    public function test_product_creation_fails_with_invalid_data()
    {
        // Crear un usuario autenticado
        $user = User::factory()->create(); 
        $this->actingAs($user);
        // Enviar datos con información faltante o incorrecta
        $response = $this->post(route('productos.store'), [
            'nombre' => '', // Nombre vacío (debe ser obligatorio)
            'descripcion' => 'Juego de pelea con todos los personajes y contenido adicional',
            'precio' => -10, // Precio negativo (debe ser un valor positivo)
            'stock' => 10,
            'categoria_id' => null, // Categoria faltante (debe ser una categoría válida)
            'images' => [], // Imagen faltante (debe existir una imagen)
        ]);
        // Verificar que la respuesta es un error de validación
        $response->assertSessionHasErrors([
            'nombre', // Se espera error en el campo 'nombre'
            'precio', // Se espera error en el campo 'precio'
            'categoria_id', // Se espera error en el campo 'categoria_id'
            'images', // Se espera error en el campo 'images'
        ]);
        // Verificar que los mensajes de error son los correctos (según tus reglas de validación)
        $response->assertSessionHas('errors');
        $errors = session('errors')->getMessages();
        $this->assertArrayHasKey('nombre', $errors);
        $this->assertArrayHasKey('precio', $errors);
        $this->assertArrayHasKey('categoria_id', $errors);
        $this->assertArrayHasKey('images', $errors);
    }
    // ************************************************************* TEST CUATRO *************************************************************
    public function test_product_deletion_removes_record_and_redirects()
    {
        // Crear un usuario autenticado
        $user = User::factory()->create(); 
        $this->actingAs($user);
        // Crear una categoría para el producto
        $categoria = Categoria::factory()->create();
        // Crear un producto asociado al usuario autenticado
        $product = Producto::factory()->create([
            'user_id' => $user->id,
            'nombre' => 'MK 11 ULTIMATE',
            'precio' => 100,
            'stock' => 10,
            'categoria_id' => $categoria->id,
        ]);
        // Asegurar que el producto existe en la base de datos
        $this->assertDatabaseHas('productos', [
            'id' => $product->id,
            'nombre' => 'MK 11 ULTIMATE',
        ]);
        // Realizar la petición DELETE para eliminar el producto
        $response = $this->delete(route('productos.destroy', $product->id));
    }
}
