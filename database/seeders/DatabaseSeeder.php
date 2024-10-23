<?php

namespace Database\Seeders;

use App\Models\Malfunction;
use App\Models\Equipment;
use App\Models\Technician;
use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Technician::factory(5)->create();
        Equipment::factory(10)->create();
        Ticket::factory(20)->create();
        Malfunction::factory(20)->create();


        User::factory()->create([
            'name' => 'Leandro',
            'email' => 'admin@gmail.com',
            'password' => '123456789',
        ]);
    }
}
