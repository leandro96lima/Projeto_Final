<?php

namespace Database\Seeders;

use App\Models\Admin;
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
//        User::factory(10)->create();
//        Technician::factory(5)->create();
//        equipments::factory(10)->create();
//        Ticket::factory(20)->create();
//        Malfunction::factory(20)->create();


        Admin::factory()->create([
            'name' => 'Leandro',
            'email' => 'admin@gmail.com',
            'password' => '123456789',
            'type' => 'Admin'
        ]);
    }
}
