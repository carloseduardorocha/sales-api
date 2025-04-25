<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Sale;
use App\Models\Seller;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /** Seed the application's database. */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name'     => env('TEST_USER_NAME'),
            'email'    => env('TEST_USER_EMAIL'),
            'password' => Hash::make(env('TEST_USER_PASSWORD')),
        ]);

        Seller::factory(15)->create();
        Sale::factory(50)->create();
    }
}
