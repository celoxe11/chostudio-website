<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artworks = [
            [
                'title' => 'Sunset Dreams',
                'description' => 'A vibrant sunset landscape with dreamy colors and soft brush strokes.',
                'image_url' => 'gallery/1.jpg',
                'file_format' => 'PSD',
                'status' => 'available',
                'price' => 150000.00,
            ],
            [
                'title' => 'Urban Jungle',
                'description' => 'Modern cityscape with nature elements blending in.',
                'image_url' => 'gallery/2.jpg',
                'file_format' => 'AI',
                'status' => 'available',
                'price' => 200000.00,
            ],
            [
                'title' => 'Ocean Waves',
                'description' => 'Serene ocean scene with gentle waves and peaceful atmosphere.',
                'image_url' => 'gallery/3.jpg',
                'file_format' => 'PNG',
                'status' => 'available',
                'price' => 120000.00,
            ],
            [
                'title' => 'Midnight Garden',
                'description' => 'Mystical garden scene under moonlight with glowing flowers.',
                'image_url' => 'gallery/4.jpeg',
                'file_format' => 'PSD',
                'status' => 'sold',
                'price' => 180000.00,
            ],
            [
                'title' => 'Cherry Blossom',
                'description' => 'Beautiful cherry blossom tree in full bloom.',
                'image_url' => 'gallery/5.jpg',
                'file_format' => 'PNG',
                'status' => 'available',
                'price' => 135000.00,
            ],
            [
                'title' => 'Starry Night Sky',
                'description' => 'Breathtaking night sky filled with stars and nebula.',
                'image_url' => 'gallery/6.jpg',
                'file_format' => 'AI',
                'status' => 'available',
                'price' => 175000.00,
            ],
            [
                'title' => 'Mountain Peak',
                'description' => 'Majestic mountain landscape with snow-capped peaks.',
                'image_url' => 'gallery/7.jpg',
                'file_format' => 'PSD',
                'status' => 'available',
                'price' => 160000.00,
            ],
            [
                'title' => 'Autumn Forest',
                'description' => 'Golden autumn forest with warm colors and falling leaves.',
                'image_url' => 'gallery/8.jpeg',
                'file_format' => 'PNG',
                'status' => 'available',
                'price' => 140000.00,
            ],
            [
                'title' => 'Cosmic Galaxy',
                'description' => 'Abstract cosmic art with swirling galaxies and vibrant colors.',
                'image_url' => 'gallery/9.jpeg',
                'file_format' => 'AI',
                'status' => 'not_sold',
                'price' => 190000.00,
            ],
            [
                'title' => 'Desert Dunes',
                'description' => 'Peaceful desert landscape with rolling sand dunes.',
                'image_url' => 'gallery/10.jpg',
                'file_format' => 'PSD',
                'status' => 'available',
                'price' => 145000.00,
            ],
        ];

        foreach ($artworks as $artwork) {
            Gallery::create($artwork);
        }
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

