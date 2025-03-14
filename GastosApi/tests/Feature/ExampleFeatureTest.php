<?php

namespace Tests\Feature;

use Tests\TestCase; // Cambiar PHPUnit\Framework\TestCase por Tests\TestCase
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Gasto;

class ExampleFeatureTest extends TestCase
{
    use RefreshDatabase; // Permite resetear la base de datos en cada prueba

    //Test creacion usuario*/
    public function test_user_creation(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    // Test creacion gasto/
    public function test_gasto_creation(): void
    {
        $user = User::factory()->create();
        $gasto = Gasto::factory()->create([
            'user_id' => $user->id,
            'description' => 'Compra de supermercado',
            'amount' => 50.00,
            'category' => 'Comestibles',
        ]);

        $this->assertDatabaseHas('gastos', ['description' => 'Compra de supermercado']);
    }
    // Test edidar gasto
    public function test_gasto_update(): void
    {
        $user = User::factory()->create();
        $gasto = Gasto::factory()->create([
            'user_id' => $user->id,
            'description' => 'Compra de supermercado',
            'amount' => 50.00,
            'category' => 'Comestibles',
        ]);

        $gasto->update([
            'description' => 'Compra de ropa',
            'amount' => 100.00,
            'category' => 'Ropa',
        ]);

        $this->assertDatabaseHas('gastos', ['description' => 'Compra de ropa', 'amount' => 100.00, 'category' => 'Ropa']);
    }

    // Test eliminar gasto
    public function test_gasto_deletion(): void
    {
        $user = User::factory()->create();
        $gasto = Gasto::factory()->create([
            'user_id' => $user->id,
            'description' => 'Compra de supermercado',
            'amount' => 50.00,
            'category' => 'Comestibles',
        ]);

        $gasto->delete();

        $this->assertDatabaseMissing('gastos', ['description' => 'Compra de supermercado']);
    }
}
