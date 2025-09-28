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