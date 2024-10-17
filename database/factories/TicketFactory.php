<?php

namespace Database\Factories;

use App\Models\Malfunction;
use App\Models\Technician;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'open_date' => $this->faker->dateTime(),
            'close_date' => null,
            'wait_time' => $this->faker->numberBetween(1, 24),
            'urgent' => $this->faker->boolean(),
            'technician_id' => Technician::factory(),
            'malfunction_id' => Malfunction::factory(),
        ];
    }
}
