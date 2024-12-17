<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Guest',
        //     'email' => 'guest@singadu.id',
        //     'password' => bcrypt('123'),
        // ]);

        // User::factory()->create([
        //     'name' => 'Staff',
        //     'email' => 'staff@singadu.id',
        //     'password' => bcrypt('123'),
        //     'role' => 'staff',
        // ]);
        User::factory()->create([
            'name' => 'Head Staff',
            'email' => 'hstaff@singadu.id',
            'password' => bcrypt('123'),
            'role' => 'head_staff',
        ]);
    }
}
