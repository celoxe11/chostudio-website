<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtistCommisionController extends Controller
{
    function index() {
        return view('artist.commisions');
    }

    function detail() {
        return view("artist.commision_detail");
    }
}
