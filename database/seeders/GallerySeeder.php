<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $galleries = [];

        // Status disiapkan: 15 available, 2 sold, 3 archived
        $statuses = array_merge(
            array_fill(0, 15, 'available'),
            array_fill(0, 2, 'sold'),
            array_fill(0, 3, 'archived')
        );
        shuffle($statuses);

        for ($i = 1; $i <= 20; $i++) {
            $galleries[] = [
                'title' => 'Artwork ' . Str::random(5),
                'description' => 'Deskripsi karya seni ke-' . $i,
                'image_url' => 'https://via.placeholder.com/600x400',
                'file_format' => collect(['jpg', 'png', 'jpeg'])->random(),
                'status' => $statuses[$i - 1],
                'price' => rand(30000, 60000),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($galleries as $galleryData) {
            DB::table('gallery')->insert([
                'title' => $galleryData['title'],
                'description' => $galleryData['description'],
                'image_url' => $galleryData['image_url'],
                'file_format' => $galleryData['file_format']?? 'jpg',
                'status' => $galleryData['status'],
                'price' => $galleryData['price'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
         $this->command->info('✅ GallerySeeder: 20 data inserted');
    }
}
