<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apartment>
 */
class ApartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $blocks = ['Reservas del Oriente', 'Termitas', 'Centro de Garzón', 'Independientes'];
        $block = $this->faker->randomElement($blocks);
        
        return [
            'name' => $this->generateApartmentName($block),
            'address' => 'Garzón - Huila',
            'price' => $this->faker->numberBetween(300000, 1200000),
            'is_rented' => $this->faker->boolean(80), // 80% probability of being rented
            'block' => $block,
            'description' => $this->faker->paragraph(),
            'bedrooms' => $this->faker->numberBetween(1, 4),
            'bathrooms' => $this->faker->numberBetween(1, 3),
            'area' => $this->faker->numberBetween(40, 120),
            'floor' => $this->faker->numberBetween(1, 5),
            'unit_number' => $this->faker->numberBetween(101, 999),
            'amenities' => $this->faker->randomElements([
                'WiFi', 'Estacionamiento', 'Ascensor', 'Seguridad 24/7', 
                'Área de lavandería', 'Balcón', 'Closet', 'Cocina equipada'
            ], $this->faker->numberBetween(2, 5)),
            'status' => $this->faker->randomElement(['available', 'rented', 'maintenance']),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Generate apartment name based on block.
     */
    private function generateApartmentName(string $block): string
    {
        $prefix = match($block) {
            'Reservas del Oriente' => 'Apto RO-',
            'Termitas' => 'Apto Termitas ',
            'Centro de Garzón' => $this->faker->randomElement(['Apto Zacarias ', 'Apto Castillo ']),
            'Independientes' => $this->faker->randomElement(['Casa Tania', 'Casa Juan XXIII']),
            default => 'Apto '
        };

        if ($block === 'Independientes') {
            return $prefix;
        }

        return $prefix . $this->faker->numberBetween(101, 999);
    }

    /**
     * Indicate that the apartment is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_rented' => false,
            'status' => 'available',
        ]);
    }

    /**
     * Indicate that the apartment is rented.
     */
    public function rented(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_rented' => true,
            'status' => 'rented',
        ]);
    }
}
