<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'emanuelernestjuma@gmail.com'],
            [
                'name' => 'Emanuel Ernest Juma',
                'email' => 'emanuelernestjuma@gmail.com',
                'password' => Hash::make('Juma@1997ima'),
                'phone'=>"255753417792",
                'email_verified_at' => now(),
            ]
        );
    }
}
