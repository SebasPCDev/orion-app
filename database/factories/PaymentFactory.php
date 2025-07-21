<?php

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        return [
            'apartment_id' => Apartment::factory(),
            'user_id' => User::factory(),
            'amount' => $this->faker->numberBetween(300000, 1200000),
            'payment_date' => $this->faker->dateTimeThisYear(),
            'month' => $this->faker->randomElement($months),
            'status' => 'pagado',
            'description' => 'Pago de arriendo mensual',
        ];
    }
}
