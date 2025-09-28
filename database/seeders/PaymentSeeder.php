<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Establecer el locale a español para Carbon
        Carbon::setLocale('es');

        $usersWithApartments = User::whereHas('apartment')->with('apartment')->get();

        foreach ($usersWithApartments as $user) {
            $apartment = $user->apartment;
            if ($apartment) {
                for ($month = 1; $month <= 8; $month++) {
                    $paymentDate = Carbon::create(2025, $month, 5);
                    $monthName = ucfirst($paymentDate->monthName);

                    $user->payments()->create([
                        'apartment_id' => $apartment->id,
                        'amount' => $apartment->price,
                        'payment_date' => $paymentDate,
                        'month' => $monthName,
                        'status' => 'pagado',
                        'description' => "Pago de arriendo para el mes de {$monthName}",
                    ]);
                }
            }
        }
    }
}
