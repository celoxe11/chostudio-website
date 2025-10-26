<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;

class ArtistCommisionDetailController extends Controller
{
    public function detail($id)
    {
        $commission = Commission::with(['progressImages', 'member'])
            ->findOrFail($id);
        // dd($commission);
        return view("artist.commision_detail", [
            'commission' => $commission,
            'member' => $commission->member
        ]);
    }
}
