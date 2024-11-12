<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MarketplaceTest extends TestCase
{
    // *************************************************************** TEST UNO* **************************************************************
    public function test_authenticated_user_sees_dashboard_with_welcome_message()
    {
        // Crear un usuario de prueba
        $user = User::factory()->create();
        // Simular que el usuario inicia sesión y visita la ruta dashboard
        $response = $this->actingAs($user)->get('/dashboard');
        // Verificar que el código de respuesta es 200 y que se muestra el mensaje de bienvenida
        $response->assertStatus(200);
        $response->assertSee('Bienvenido al Dashboard'); // Cambia el texto si es diferente
    }
    // *************************************************************** TEST DOS ***************************************************************
    public function test_product_creation_creates_record_and_redirects()
    {
        // Crear un usuario y simular que inicia sesión
        $user = User::factory()->create();
        // Simular envío de datos para crear un producto
        $response = $this->actingAs($user)->post('/productos', [
            'nombre' => 'Producto de prueba',
            'descripcion' => 'Descripción del producto',
            'precio' => 100,
            'stock' => 10,
            'categoria' => 'Accesorios'
        ]);
        // Verificar que la base de datos tiene el producto creado
        $this->assertDatabaseHas('productos', ['nombre' => 'Producto de prueba']);
        // Verificar redirección después de la creación
        $response->assertRedirect('/productos');
    }    
    // ************************************************************** TEST  TRES **************************************************************
    public function test_product_creation_shows_validation_errors_on_invalid_data()
    {
        // Crear un usuario de prueba
        $user = User::factory()->create();
        // Enviar datos incorrectos para crear un producto
        $response = $this->actingAs($user)->post('/productos', [
            'nombre' => '', // Nombre vacío
            'precio' => -10, // Precio negativo para provocar un error
            'stock' => 10
        ]);
        // Verificar que se muestran errores de validación
        $response->assertSessionHasErrors(['nombre', 'precio']);
    }
    // ************************************************************* TEST  CUATRO *************************************************************
    public function test_product_deletion_marks_as_deleted_and_redirects()
    {
        // Crear un usuario y un producto de prueba
        $user = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $user->id]);
        // Simular la petición de eliminación
        $response = $this->actingAs($user)->delete("/productos/{$product->id}");
        // Verificar que el producto esté marcado como eliminado (SoftDelete)
        $this->assertSoftDeleted('productos', ['id' => $product->id]);
        // Verificar redirección después de la eliminación
        $response->assertRedirect('/productos');
    }
}
