<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::on('testing')->create([
            'name' => 'Darlene Simonis PhD',
            'email' => '0tis5oanmc@rfcdrive.com',
            'password' => fake()->password(8),
        ]);
    }
}
