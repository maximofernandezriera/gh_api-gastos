<?php

namespace Database\Factories;

use App\Models\Gasto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GastoFactory extends Factory
{
    protected $model = Gasto::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Crea un usuario automáticamente
            'description' => $this->faker->sentence(),
            'amount' => $this->faker->randomFloat(2, 1, 500), // Genera un monto entre 1 y 500
            'category' => $this->faker->randomElement([
                'Comestibles', 'Ocio', 'Electrónica', 'Utilidades', 'Ropa', 'Salud', 'Otros'
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}