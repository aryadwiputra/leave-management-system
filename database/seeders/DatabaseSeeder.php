<?php

namespace Database\Seeders;

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
        $this->call([
            PositionsSeeder::class,
        ]);

        User::factory()->create([
            'position_id' => 1,
            'department_id' => 1,
            'name' => 'Test User',
            'username' => 'test',
            'email' => 'test@example.com',
            'phone' => '089662164536',
            'join_year' => '2024',
        ]);
    }
}
