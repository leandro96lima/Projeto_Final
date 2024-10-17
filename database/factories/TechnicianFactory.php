<?php

namespace Database\Factories;

use App\Models\Technician;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Technician>
 */
class TechnicianFactory extends Factory
{
    protected $model = Technician::class;

    public function definition()
    {
        return [
            'specialty' => $this->faker->randomElement(['Electrical', 'Mechanical', 'Software']),
            'user_id' => User::factory(),
        ];
    }
}
