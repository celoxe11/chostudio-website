<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleryData = [
            [
                'title' => 'Dreamy Forest',
                'description' => 'An ethereal forest painted in soft digital tones.',
                'image_url' => 'https://placehold.co/600x400/87CEFA/FFFFFF?text=Dreamy+Forest',
                'file_format' => 'jpg',
                'status' => 'available',
                'price' => 45000,
            ],
            [
                'title' => 'Cyber Girl',
                'description' => 'Futuristic character concept in neon hues.',
                'image_url' => 'https://placehold.co/600x400/FFB6C1/000000?text=Cyber+Girl',
                'file_format' => 'png',
                'status' => 'available',
                'price' => 60000,
            ],
            [
                'title' => 'Evening Sky',
                'description' => 'Soft pastel tones capturing the last light of the day.',
                'image_url' => 'https://placehold.co/600x400/F0E68C/000000?text=Evening+Sky',
                'file_format' => 'jpeg',
                'status' => 'available',
                'price' => 38000,
            ],
            [
                'title' => 'Star Guardian',
                'description' => 'A fantasy illustration of a celestial guardian with glowing wings.',
                'image_url' => 'https://placehold.co/600x400/BA55D3/FFFFFF?text=Star+Guardian',
                'file_format' => 'jpg',
                'status' => 'sold',
                'price' => 75000,
            ],
            [
                'title' => 'Forgotten City',
                'description' => 'Concept art of an abandoned city covered in vines.',
                'image_url' => 'https://placehold.co/600x400/778899/FFFFFF?text=Forgotten+City',
                'file_format' => 'png',
                'status' => 'archived',
                'price' => 52000,
            ],
        ];

        foreach ($galleryData as $gallery) {
            DB::table('gallery')->insert(array_merge($gallery, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('✅ GallerySeeder: Dummy gallery data inserted successfully!');
    }
}

