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
            'description' => implode(' ', $this->faker->words(20)), // Generates a description with 30 words
            'urgent' => $this->faker->boolean(),
            'open_date' => $this->faker->dateTime(),
            'close_date' => null,
            'wait_time' => $this->faker->numberBetween(1, 60),
            'resolution_time' => $this->faker->numberBetween(1, 48),
            'technician_id' => Technician::factory(),
            'malfunction_id' => Malfunction::factory(),
        ];
    }

}
