<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\Malfunction;
use App\Models\Technician;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Malfunction>
 */
class MalfunctionFactory extends Factory
{
    protected $model = Malfunction::class;

    public function definition()
    {
        return [
            'status' => $this->faker->randomElement(['open', 'closed', 'in-progress']),
            'cost' => $this->faker->randomFloat(2, 100, 5000),
            'resolution_time' => $this->faker->numberBetween(1, 48),
            'diagnosis' => $this->faker->sentence(),
            'solution' => $this->faker->sentence(),
            'equipment_id' => Equipment::factory(),
            'technician_id' => Technician::factory()
        ];
    }

}
