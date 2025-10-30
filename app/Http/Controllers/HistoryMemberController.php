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

    public function getHistory(Request $request)
    {
        $user = auth()->user();

        // 1. Extract Filters from Request
        $type = $request->input('type', 'all');
        $search = $request->input('search');
        $commissionStatus = $request->input('commission_status', 'all');
        $adoptionStatus = $request->input('adoption_status', 'all');

        $historyData = collect();

        // 2. Query Commissions (if 'all' or 'commission' is selected)
        if ($type === 'all' || strtolower($type) === 'commission') {
            $commissions = Commission::where('member_id', $user->member_id)
                // Apply search filter if present
                ->when($search, function ($query, $term) {
                    return $query->where('title', 'like', '%' . $term . '%');
                })
                // Apply commission status filter if not 'all'
                ->when(strtolower($commissionStatus) !== 'all', function ($query) use ($commissionStatus) {
                    return $query->where('progress_status', strtolower($commissionStatus));
                })
                ->get();

            $historyData = $historyData->merge($commissions->map(function ($commission) {
                return [
                    ...$commission->toArray(),
                    'type' => 'Commission',
                ];
            }));
        }

        // 3. Query Adoptions (if 'all' or 'adoption' is selected)
        if ($type === 'all' || strtolower($type) === 'adoption') {
            $adoptions = Adoption::where('buyer_email', $user->email)
                // Apply search filter if present
                ->when($search, function ($query, $term) {
                    return $query->where('title', 'like', '%' . $term . '%');
                })
                // Apply adoption status filter if not 'all'
                ->when(strtolower($adoptionStatus) !== 'all', function ($query) use ($adoptionStatus) {
                    return $query->where('order_status', strtolower($adoptionStatus));
                })
                ->get();

            $historyData = $historyData->merge($adoptions->map(function ($adoption) {
                return [
                    ...$adoption->toArray(),
                    'type' => 'Adoption',
                ];
            }));
        }

        // 4. Sort and return
        $historyData = $historyData->sortByDesc('created_at')->values();

        return response()->json([
            'success' => true,
            'data' => $historyData,
        ]);
    }

    public function adoption_detail($id)
    {
        $adoption = Adoption::with("gallery")->find($id);

        if (!$adoption) {
            abort(404, 'Adoption data not found.');
        }

        return view('member.history_adoption_detail', ['adoption' => $adoption]);
    }

    public function commission_detail($id)
    {
        $commission = Commission::with(['progressImages', 'member'])
            ->findOrFail($id);

        if (!$commission) {
            abort(404, 'Commission data not found.');
        }

        return view('member.history_commission_detail', ['commission' => $commission, 'member' => $commission->member]);
    }
}
