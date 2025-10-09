<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtistAdoptionController extends Controller
{
    function index() {
        return view("artist.adoptions");
    }

    function detail() {
        return view("artist.adoption_detail");
    }
}
