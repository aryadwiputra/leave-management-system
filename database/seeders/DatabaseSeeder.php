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

        $users = [
            [
                'position_id' => 1,
                'department_id' => 1,
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'phone' => '089662164536',
                'join_year' => '2024',
                'password' => bcrypt('password'),
            ],
            [
                'position_id' => 1,
                'department_id' => 1,
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@example.com',
                'phone' => '089662164536',
                'join_year' => '2024',
                'password' => bcrypt('password'),
            ],
            [
                'position_id' => 1,
                'department_id' => 1,
                'name' => 'Guest',
                'username' => 'guest',
                'email' => 'guest@example.com',
                'phone' => '089662164536',
                'join_year' => '2024',
                'password' => bcrypt('password'),
            ],
            [
                'position_id' => 1,
                'department_id' => 1,
                'name' => 'Staff',
                'username' => 'staff',
                'email' => 'staff@example.com',
                'phone' => '089662164536',
                'join_year' => '2024',
                'password' => bcrypt('password'),
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
