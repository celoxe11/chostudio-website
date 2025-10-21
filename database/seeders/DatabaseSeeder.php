<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // note: 
        // php artisan migrate:fresh --seed untuk reset database dan seeding ulang

        $this->call([
            MemberSeeder::class,
            GallerySeeder::class,
            CommissionSeeder::class,
            AdoptionSeeder::class,
            CommissionProgressSeeder::class,
        ]);
    }
}
