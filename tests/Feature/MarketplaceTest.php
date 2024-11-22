<?php

namespace Tests\Feature;

use App\Models\User; // Modelo User
use App\Models\Categoria; // Modelo Categoria
use App\Models\Producto; // Modelo Producto
use Illuminate\Support\Facades\DB; // Para las transacciones con la base de datos
use Illuminate\Support\Facades\Hash; // Para el hashing de contraseñas
use Illuminate\Foundation\Testing\RefreshDatabase; // Para reiniciar la base de datos en cada prueba
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MarketplaceTest extends TestCase
{
    use RefreshDatabase;
    // *************************************************************** TEST UNO* **************************************************************
    public function test_authenticated_user_sees_dashboard_with_welcome_message()
    {
        $user = User::factory()->create(); // Crear un usuario de prueba
        $response = $this->actingAs($user)->get('/dashboard'); // Simular inicio de sesión y acceso
        $response->assertStatus(200); // Verificar que la respuesta es 200
        $response->assertSee('Bienvenido, ' . $user->name); // Verificar que el mensaje se muestra 
    }
    // *************************************************************** TEST DOS ***************************************************************
    public function test_product_creation_creates_record_and_redirects()
    {
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create(['nombre' => 'Videojuegos']);

        $response = $this->actingAs($user)->post('/productos', [
            'nombre' => 'MK 11 ULTIMATE',
            'descripcion' => 'PS4',
            'precio' => 899.99,
            'stock' => 10,
            'categoria_id' => $categoria->id,
        ]);

        $response->assertStatus(302); // Verificar redirección
        $this->assertDatabaseHas('productos', ['nombre' => 'MK 11 ULTIMATE']); // Verificar creación en la base de datos
    }    
    // ************************************************************** TEST  TRES **************************************************************
    public function test_product_creation_shows_validation_errors_on_invalid_data()
    {
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create(['nombre' => 'Videojuegos']);

        $response = $this->actingAs($user)->post('/productos', [
            'nombre' => '', // Nombre vacío
            'descripcion' => 'PS4',
            'precio' => -99.99, // Precio inválido
            'stock' => 10,
            'categoria_id' => $categoria->id,
        ]);

        $response->assertSessionHasErrors(['nombre', 'precio']); // Verificar errores de validación
    }
    // ************************************************************* TEST  CUATRO *************************************************************
    public function test_product_deletion_marks_as_deleted_and_redirects()
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/productos/{$producto->id}");

        $response->assertRedirect('/productos'); // Verificar redirección
        $this->assertSoftDeleted('productos', ['id' => $producto->id]); // Verificar borrado lógico
    }
}
