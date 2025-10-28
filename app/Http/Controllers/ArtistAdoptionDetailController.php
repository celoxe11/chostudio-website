<?php

namespace App\Http\Controllers;

use App\Mail\AdoptionDeliveryMail;
use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ArtistAdoptionDetailController extends Controller
{
    public function detail($adoptionId)
    {
        $adoption = Adoption::with('gallery')->findOrFail($adoptionId);
        // dd($adoption);
        return view("artist.adoption_detail", ["adoption" => $adoption]);
    }

    function update_order_status(Request $request, $adoptionId)
    {
        // update order status
        $request->validate([
            'status' => 'required|string|in:confirmed,cancelled,processing,delivered,completed'
        ]);

        $adoption = Adoption::findOrFail($adoptionId);
        $adoption->order_status = $request->status;
        $adoption->save();

        return response()->json([
            'success' => true,
            'message' => 'Adoption status updated successfully.'
        ]);
    }

    function confirm_payment($adoptionId)
    {
        $adoption = Adoption::findOrFail($adoptionId);
        $adoption->payment_status = 'paid';
        $adoption->paid_at = now();
        $adoption->order_status = 'processing'; // immidiately move to processing after payment confirmed
        $adoption->save();

        return response()->json([
            'success' => true,
            'message' => 'Adoption payment status confirmed.'
        ]);
    }

    function save_notes(Request $request, $adoptionId)
    {
        $request->validate([
            'delivery_notes' => 'nullable|string|max:2000'
        ]);

        $adoption = Adoption::findOrFail($adoptionId);
        $adoption->delivery_notes = $request->delivery_notes;
        $adoption->save();

        return response()->json([
            'success' => true,
            'message' => 'Delivery notes saved successfully.'
        ]);
    }

    function deliver_file(Request $request, $adoptionId)
    {
        $request->validate([
            'delivery_file' => 'nullable|file|max:10240', // max 10MB
        ]);

        // dd($request->all());

        $adoption = Adoption::findOrFail($adoptionId);

        if ($request->hasFile('delivery_file')) {
            $uploadPath = public_path('adoptions/' . $adoptionId);
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $extension = $request->file('delivery_file')->getClientOriginalExtension();
            $filename = 'delivery_' . time() . '.' . $extension;
            $request->file('delivery_file')->move($uploadPath, $filename);
            $imagePath = 'adoptions/' . $adoptionId . '/' . $filename;
            $adoption->delivery_files = [$imagePath];
            $fileOrLink = asset($imagePath);
        } else if ($request->filled('delivery_link')) {
            $adoption->delivery_files = [$request->delivery_link];
            $fileOrLink = $request->delivery_link;
        } else {
            return response()->json(['error' => 'No file or link provided'], 422);
        }

        $adoption->order_status = 'delivered';
        $adoption->delivered_at = now();
        $adoption->save();

        Mail::to($adoption->buyer_email)->send(new AdoptionDeliveryMail($adoption, $fileOrLink));

        return response()->json(['success' => true, 'message' => 'Files delivered and email sent.']);
    }
}
