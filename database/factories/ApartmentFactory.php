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
     * Generate mock images for apartments.
     */
    private function generateMockImages(): array
    {
        $apartmentImages = [
            'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1505873242700-f289a29e1e0f?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1571624436279-b272aff752b5?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1583608205776-bfd35f0d9f83?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1615529328331-f8917597711f?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1567767292278-a4f21aa2d36e?w=400&h=300&fit=crop',
        ];

        // Seleccionar entre 4-8 imágenes aleatorias
        $imageCount = $this->faker->numberBetween(4, 8);
        $shuffledImages = collect($apartmentImages)->shuffle();
        
        return $shuffledImages->take($imageCount)->values()->toArray();
    }

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
            'images' => $this->generateMockImages(),
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
