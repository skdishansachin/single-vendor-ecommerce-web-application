<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Create customers
        User::factory()
            ->count(20)
            ->create()
            ->each(function (User $user) {
                $user->assignRole('customer');
            });

        // Create customers with banded
        User::factory()
            ->count(5)
            ->banned()
            ->create()
            ->each(function (User $user) {
                $user->assignRole('customer');
            });
    }
}
