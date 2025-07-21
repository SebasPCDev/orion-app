<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        // Reservas del Oriente
        $this->createReservasDelOriente($user);
        
        // Termitas
        $this->createTermitas($user);
        
        // Centro de Garzón
        $this->createCentroGarzon($user);
        
        // Independientes
        $this->createIndependientes($user);
    }

    private function createReservasDelOriente(User $user): void
    {
        $apartments = [
            ['name' => 'Apto RO-101', 'price' => 500000, 'is_rented' => true],
            ['name' => 'Apto RO-102', 'price' => 450000, 'is_rented' => false],
            ['name' => 'Apto RO-201', 'price' => 650000, 'is_rented' => true],
            ['name' => 'Apto RO-202', 'price' => 700000, 'is_rented' => true],
            ['name' => 'Apto Pensión 101', 'price' => 530000, 'is_rented' => true],
            ['name' => 'Apto Pensión 201', 'price' => 520000, 'is_rented' => true],
        ];

        foreach ($apartments as $apt) {
            Apartment::create([
                'name' => $apt['name'],
                'address' => 'Garzón - Huila',
                'price' => $apt['price'],
                'is_rented' => $apt['is_rented'],
                'block' => 'Reservas del Oriente',
                'description' => 'Apartamento ubicado en el bloque Reservas del Oriente',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'area' => 60,
                'floor' => substr($apt['name'], -3, 1),
                'unit_number' => substr($apt['name'], -3),
                'amenities' => ['WiFi', 'Estacionamiento', 'Seguridad 24/7'],
                'status' => $apt['is_rented'] ? 'rented' : 'available',
                'user_id' => $user->id,
            ]);
        }
    }

    private function createTermitas(User $user): void
    {
        $apartments = [
            ['name' => 'Apto Termitas 201', 'price' => 370000, 'is_rented' => true],
            ['name' => 'Apto Termitas 202', 'price' => 400000, 'is_rented' => true],
            ['name' => 'Apto Termitas 203', 'price' => 400000, 'is_rented' => true],
        ];

        foreach ($apartments as $apt) {
            Apartment::create([
                'name' => $apt['name'],
                'address' => 'Garzón - Huila',
                'price' => $apt['price'],
                'is_rented' => $apt['is_rented'],
                'block' => 'Termitas',
                'description' => 'Apartamento ubicado en el bloque Termitas',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'area' => 55,
                'floor' => substr($apt['name'], -3, 1),
                'unit_number' => substr($apt['name'], -3),
                'amenities' => ['WiFi', 'Estacionamiento'],
                'status' => 'rented',
                'user_id' => $user->id,
            ]);
        }
    }

    private function createCentroGarzon(User $user): void
    {
        $apartments = [
            ['name' => 'Apto Zacarias 101', 'price' => 350000, 'is_rented' => true],
            ['name' => 'Apto Castillo 101', 'price' => 440000, 'is_rented' => true],
            ['name' => 'Apto Castillo 102', 'price' => 400000, 'is_rented' => true],
            ['name' => 'Apto Castillo 201', 'price' => 400000, 'is_rented' => true],
        ];

        foreach ($apartments as $apt) {
            Apartment::create([
                'name' => $apt['name'],
                'address' => 'Garzón - Huila',
                'price' => $apt['price'],
                'is_rented' => $apt['is_rented'],
                'block' => 'Centro de Garzón',
                'description' => 'Apartamento ubicado en el centro de Garzón',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'area' => 50,
                'floor' => substr($apt['name'], -3, 1),
                'unit_number' => substr($apt['name'], -3),
                'amenities' => ['WiFi', 'Estacionamiento', 'Balcón'],
                'status' => 'rented',
                'user_id' => $user->id,
            ]);
        }
    }

    private function createIndependientes(User $user): void
    {
        $apartments = [
            ['name' => 'Casa Tania', 'price' => 1200000, 'is_rented' => true],
            ['name' => 'Casa Juan XXIII', 'price' => 650000, 'is_rented' => true],
        ];

        foreach ($apartments as $apt) {
            Apartment::create([
                'name' => $apt['name'],
                'address' => $apt['name'] === 'Casa Juan XXIII' ? 'Florencia - Caquetá' : 'Garzón - Huila',
                'price' => $apt['price'],
                'is_rented' => $apt['is_rented'],
                'block' => 'Independientes',
                'description' => 'Casa independiente con todas las comodidades',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 100,
                'floor' => 1,
                'unit_number' => null,
                'amenities' => ['WiFi', 'Estacionamiento', 'Jardín', 'Cocina equipada', 'Closet'],
                'status' => 'rented',
                'user_id' => $user->id,
            ]);
        }
    }
}
