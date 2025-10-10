<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtistGalleryController extends Controller
{
    public function index()
    {
        $galleryData = [
            [
                'image_url' => 'https://i.pinimg.com/736x/5e/9f/65/5e9f65e0f0f7ae98a731857b173538a2.jpg',
                'title' => 'Cats Tea',
                'description' => 'A calm digital painting of a misty morning forest.',
                'price' => 25000,
                'file_type' => 'PNG',
                'purchase' => true,
            ],
            [
                'image_url' => 'https://i.pinimg.com/1200x/ca/78/7b/ca787bb4d93748a5cb32b60a0cb1bb29.jpg',
                'title' => 'Cyberpunk',
                'description' => 'Futuristic Human Robots glowing in neon lights.',
                'price' => 40,
                'file_type' => 'PSD',
                'purchase' => true,
            ],
            [
                'image_url' => 'https://i.pinimg.com/1200x/27/78/b5/2778b541222534e0d830a10a36cf7aa3.jpg',
                'title' => 'Ocean Depths',
                'description' => 'A serene underwater world illustration.',
                'price' => 30,
                'file_type' => 'JPG',
                'purchase' => false,
            ],
            // dst...
        ];


        return view('artist.gallery', compact('galleryData'));
    }
}
