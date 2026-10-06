<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Wande Admin',
            'email' => 'wande@hrms.com',
            'password' => Hash::make('password'),
        ]);

        // HR
        User::factory()->create([
            'name' => 'HR Manager',
            'email' => 'hr@hrms.com',
            'password' => Hash::make('password'),
        ]);

        // Employee
        User::factory()->create([
            'name' => 'Test Employee',
            'email' => 'employee@hrms.com',
            'password' => Hash::make('password'),
        ]);
    }
}