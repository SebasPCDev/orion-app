<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
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
        $imageCount = rand(4, 8);
        $shuffledImages = collect($apartmentImages)->shuffle();
        
        return $shuffledImages->take($imageCount)->values()->toArray();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allApartmentData = array_merge(
            $this->getReservasDelOrienteData(),
            $this->getTermitasData(),
            $this->getCentroGarzonData(),
            $this->getIndependientesData()
        );

        $rentedApartmentsCount = collect($allApartmentData)->where('is_rented', true)->count();
        // Omitimos el usuario con ID 1
        $users = User::where('id', '!=', 1)->get();

        if ($users->count() < $rentedApartmentsCount) {
            User::factory()->count($rentedApartmentsCount - $users->count())->create();
            // Volvemos a obtener los usuarios, omitiendo el ID 1
            $users = User::where('id', '!=', 1)->get();
        }

        $userIterator = $users->shuffle()->getIterator();

        foreach ($allApartmentData as $aptData) {
            $aptData['user_id'] = null;
            if ($aptData['is_rented']) {
                if ($userIterator->valid()) {
                    $aptData['user_id'] = $userIterator->current()->id;
                    $userIterator->next();
                }
            }
            // Agregar imágenes mock a cada apartamento
            $aptData['images'] = $this->generateMockImages();
            Apartment::create($aptData);
        }
    }

    private function getReservasDelOrienteData(): array
    {
        $apartments = [
            ['name' => 'Apto RO-101', 'price' => 500000, 'is_rented' => true],
            ['name' => 'Apto RO-102', 'price' => 450000, 'is_rented' => false],
            ['name' => 'Apto RO-201', 'price' => 650000, 'is_rented' => true],
            ['name' => 'Apto RO-202', 'price' => 700000, 'is_rented' => true],
            ['name' => 'Apto Pensión 101', 'price' => 530000, 'is_rented' => true],
            ['name' => 'Apto Pensión 201', 'price' => 520000, 'is_rented' => true],
        ];

        $data = [];
        foreach ($apartments as $apt) {
            $data[] = [
                'name' => $apt['name'],
                'address' => 'Garzón - Huila',
                'price' => $apt['price'],
                'is_rented' => $apt['is_rented'],
                'block' => 'Reservas del Oriente',
                'description' => 'Apartamento ubicado en el bloque Reservas del Oriente',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'area' => 60,
                'floor' => is_numeric(substr($apt['name'], -3, 1)) ? substr($apt['name'], -3, 1) : '1',
                'unit_number' => is_numeric(substr($apt['name'], -3)) ? substr($apt['name'], -3) : null,
                'amenities' => ['WiFi', 'Estacionamiento', 'Seguridad 24/7'],
                'status' => $apt['is_rented'] ? 'rented' : 'available',
            ];
        }
        return $data;
    }

    private function getTermitasData(): array
    {
        $apartments = [
            ['name' => 'Apto Termitas 201', 'price' => 370000, 'is_rented' => true],
            ['name' => 'Apto Termitas 202', 'price' => 400000, 'is_rented' => true],
            ['name' => 'Apto Termitas 203', 'price' => 420000, 'is_rented' => true],
        ];

        $data = [];
        foreach ($apartments as $apt) {
            $data[] = [
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
            ];
        }
        return $data;
    }

    private function getCentroGarzonData(): array
    {
        $apartments = [
            ['name' => 'Apto Zacarias 101', 'price' => 350000, 'is_rented' => true],
            ['name' => 'Apto Castillo 101', 'price' => 420000, 'is_rented' => true],
            ['name' => 'Apto Castillo 102', 'price' => 440000, 'is_rented' => true],
            ['name' => 'Apto Castillo 201', 'price' => 400000, 'is_rented' => true],
        ];

        $data = [];
        foreach ($apartments as $apt) {
            $data[] = [
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
            ];
        }
        return $data;
    }

    private function getIndependientesData(): array
    {
        $apartments = [
            ['name' => 'Casa Tania', 'price' => 560000, 'is_rented' => true],
            ['name' => 'Casa Juan XXIII', 'price' => 1050000, 'is_rented' => true],
        ];

        $data = [];
        foreach ($apartments as $apt) {
            $data[] = [
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
            ];
        }
        return $data;
    }
}