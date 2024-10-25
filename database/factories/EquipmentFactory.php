<?php

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition()
    {
        return [
            'type' => $this->faker->word(),
            'manufacturer' => $this->faker->company(),
            'model' => $this->faker->bothify('Model-####'),
            'room' => $this->faker->numberBetween(100, 500),
            'serial_number' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
        ];
    }
}
