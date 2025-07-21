<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@orion.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Tenant Users
        $tenants = [
            ['name' => 'Juan Rodriguez'],
            ['name' => 'Maria Garcia'],
            ['name' => 'Carlos Perez'],
            ['name' => 'Ana Martinez'],
            ['name' => 'Luis Hernandez'],
            ['name' => 'Sofia Gomez'],
            ['name' => 'Andres Diaz'],
            ['name' => 'Laura Sanchez'],
            ['name' => 'Diego Gonzalez'],
            ['name' => 'Valentina Torres'],
        ];

        foreach ($tenants as $tenant) {
            User::create([
                'name' => $tenant['name'],
                'email' => strtolower(str_replace(' ', '.', $tenant['name'])) . '@orion.com',
                'password' => Hash::make('password'),
                'role' => 'tenant',
            ]);
        }
    }
}
