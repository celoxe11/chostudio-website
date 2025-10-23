<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // Ambil semua ID dari tabel members untuk digunakan sebagai FK
        $memberIds = DB::table('members')->pluck('member_id'); 

        for ($i = 0; $i < 20; $i++) {
            DB::table('commisions')->insert([
                'member_id' => $faker->randomElement($memberIds), // Random FK
                'category' => $faker->randomElement(['Fullbody', 'Headshot', 'Halfbody', "Chibi", "Custom"]),
                'description' => $faker->paragraph,
                'deadline' => $faker->dateTimeBetween('+1 week', '+3 months'),
                'price' => $faker->randomFloat(2, 50, 500),
                'payment_status' => $faker->randomElement(['pending', 'dp', 'paid', 'refunded']),
                'progress_status' => $faker->randomElement(['pending', 'accepted', 'in_progress_sketch', 'in_progress_coloring', 'review', 'revision', 'completed', 'cancelled']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
