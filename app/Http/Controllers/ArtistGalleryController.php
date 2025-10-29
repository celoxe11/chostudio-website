<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtistGalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('status', 'available')->get();
         $adoptions = Adoption::with('gallery')->get();
        return response()->json($adoptions);
        return response()->json($galleries);


        return view('artist.gallery', compact('galleryData'));
    }
}
