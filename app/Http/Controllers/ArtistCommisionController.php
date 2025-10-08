<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtistCommisionController extends Controller
{
    function index() {
        return view('artist.commisions');
    }
}
