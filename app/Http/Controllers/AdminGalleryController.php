<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminGalleryController extends Controller
{
    public function index()
    {
        return view('admin.gallery');
    }
}
