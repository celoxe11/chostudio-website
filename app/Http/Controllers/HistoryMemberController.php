<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\Commission;
use Illuminate\Http\Request;

class HistoryMemberController extends Controller
{
    public function index()
    {
        return view('member.history');
    }

    public function getHistory()
    {
        // get the current authenticated user
        $user = auth()->user();

        // get users commissions form the database
        $commissions = Commission::where('member_id', $user->member_id)->get();

        // get the adoptions if the users email is found in the adoption table
        $adoptions = Adoption::where('buyer_email', $user->email)->get();

        // merge both collections and sort by created_at descending
        $historyData = $adoptions->map(function ($adoption) {
            return [
                ...$adoption->toArray(),
                'type' => 'Adoption',
            ];
        })->merge($commissions->map(function ($commission) {
            return [
                ...$commission->toArray(),
                'type' => 'Commission',
            ];
        }))->sortByDesc('created_at')->values();

        // dd($historyData);

        return response()->json([
            'success' => true,
            'data' => $historyData,
        ]);
    }

    public function detail($type, $id)
    {
        // $item = collect($this->historyData)->firstWhere('id', $id);

        // if (!$item) {
        //     abort(404, 'History item not found.');
        // }

        return view('member.history_detail');
    }
}
