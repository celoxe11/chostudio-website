<?php

namespace App\Http\Controllers;

use App\Models\Commision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtistCommisionController extends Controller
{
    public function index()
    {
        return view('artist.commisions');
    }

    public function getCommisions(Request $request)
    {
        $query = Commision::with('member');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('member', function ($memberQuery) use ($search) {
                    $memberQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('category', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('progress_status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && !empty($request->payment_status)) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $commissions = $query->paginate($perPage);

        // Get status counts
        $statusCounts = [
            'pending' => Commision::where('progress_status', 'pending')->count(),
            'in_progress' => Commision::whereIn('progress_status', ['in_progress_sketch', 'in_progress_coloring'])->count(),
            'revision' => Commision::where('progress_status', 'revision')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $commissions->items(),
            'pagination' => [
                'current_page' => $commissions->currentPage(),
                'last_page' => $commissions->lastPage(),
                'per_page' => $commissions->perPage(),
                'total' => $commissions->total(),
                'from' => $commissions->firstItem(),
                'to' => $commissions->lastItem(),
            ],
            'status_counts' => $statusCounts,
        ]);
    }

    public function detail()
    {
        return view("artist.commision_detail");
    }
}
