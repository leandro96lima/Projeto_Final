<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function withTechnician(array $technicianAttributes = []): static
    {
        return $this->afterCreating(function (User $user) use ($technicianAttributes) {
            if ($user->type === 'Technician') {
                Technician::create(array_merge([
                    'user_id' => $user->id,
                ], $technicianAttributes));
            }
        })->state(fn (array $attributes) => [
            'type' => 'Technician',
        ]);
    }

    public function withAdmin(array $adminAttributes = []): static
    {
        return $this->afterCreating(function (User $user) use ($adminAttributes) {
            if ($user->type === 'Admin') {
                Admin::create(array_merge([
                    'user_id' => $user->id,
                ], $adminAttributes));
            }
        })->state(fn (array $attributes) => [
            'type' => 'Admin',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
