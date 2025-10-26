<?php

namespace App\Http\Controllers;

use App\Models\Commision;
use App\Models\Commission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommissionMemberController extends Controller
{
    public function index()
    {
        return view('member.commission_type');
    }

    public function form(Request $request)
    {
        $category = $request->query('type', null);
        return view('member.commission_form', compact('category'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'deadline' => 'required|date|after_or_equal:' . Carbon::now()->addWeeks(2)->format('Y-m-d'),
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $memberId = Auth::id();

        // Upload file referensi jika ada
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('commission_images', 'public');
            $imageUrl = Storage::url($path);
        }

        // Simpan data
        Commission::create([
            'member_id' => $memberId,
            'category' => $validated['category'],
            'description' => $validated['description'],
            'deadline' => $validated['deadline'],
            'price' => $validated['price'],
            'image_url' => $imageUrl,
            'payment_status' => 'pending',
            'progress_status' => 'pending',
        ]);

        return redirect()->route('member.history')->with('success', 'Commission request created successfully!');
    }
}
