<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdoptionSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil gallery_id dari gallery yang available atau sold
        $eligibleGalleryIds = DB::table('gallery')
            ->whereIn('status', ['available', 'sold'])
            ->pluck('gallery_id')
            ->toArray();

        // Kalau belum ada data gallery, amanin dulu
        if (empty($eligibleGalleryIds)) {
            $this->command->warn('⚠️ Tidak ada gallery dengan status available/sold untuk adopsi!');
            return;
        }

        $adoptions = [];

        for ($i = 1; $i <= 8; $i++) {
            $adoptions[] = [
                'gallery_id' => collect($eligibleGalleryIds)->random(),
                'email' => "user{$i}@example.com",
                'order_status' => collect(['placed', 'shipped', 'delivered', 'canceled'])->random(),
                'payment_status' => collect(['pending', 'paid', 'failed'])->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('adoptions')->insert($adoptions);
        $this->command->info('✅ AdoptionSeeder: 8 data inserted');
    }
}
