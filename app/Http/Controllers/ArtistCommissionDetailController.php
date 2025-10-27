<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;

class ArtistCommissionDetailController extends Controller
{
    public function detail($id)
    {
        $commission = Commission::with(['progressImages', 'member'])
            ->findOrFail($id);
        // dd($commission);
        return view("artist.commission_detail", [
            'commission' => $commission,
            'member' => $commission->member
        ]);
    }

    function update_status(Request $request, $commissionId)
    {
        $request->validate([
            'status' => 'required|string|in:accepted,declined,in_progress_sketch, in_progress_coloring, completed, cancelled'
        ]);

        $commission = Commission::findOrFail($commissionId);
        $commission->progress_status = $request->status;
        $commission->save();

        return response()->json([
            'success' => true,
            'message' => 'Commission status updated successfully.'
        ]);
    }
}
