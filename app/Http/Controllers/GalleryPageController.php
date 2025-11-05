<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAdoptionNotification; // Pastikan Anda sudah membuat Mailable ini
use Illuminate\Support\Facades\Log;

class GalleryPageController extends Controller
{
    /**
     * Menampilkan halaman galeri dengan data dari database.
     * Mengambil HANYA galeri yang statusnya 'available'.
     */
    public function index()
    {
        // Mengambil galeri yang memiliki harga (bukan null) dan statusnya 'available'
        $designs = Gallery::whereNotNull('price')
                          ->where('status', 'available')
                          ->orderBy('created_at', 'desc')
                          ->get();
        
        return view('gallery', compact('designs'));
    }

    /**
     * Menyimpan data adopsi baru, mengunggah file, dan mengirim email.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gallery_id' => 'required|exists:gallery,gallery_id',
            'email' => 'required|email|max:255',
            'paymentProof' => 'required|image|mimes:jpeg,png,jpg|max:2048', // maks 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Ambil detail item galeri dari DB
        $galleryItem = Gallery::find($request->gallery_id);
        if (!$galleryItem || $galleryItem->status !== 'available') {
            return response()->json(['success' => false, 'message' => 'Sorry, this artwork is no longer available.'], 404);
        }

        // Handle upload file bukti pembayaran
        $filePath = null;
        if ($request->hasFile('paymentProof')) {
            $file = $request->file('paymentProof');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            // Simpan ke storage/app/public/payment_confirmations
            $filePath = $file->storeAs('payment_confirmations', $fileName, 'public');
        }

        // Buat record adopsi baru di DB, TANPA MENYIMPAN PRICE
        $adoption = Adoption::create([
            'gallery_id' => $galleryItem->gallery_id,
            'email' => $request->email,
            'payment_confirmation' => $filePath, // Menyimpan path file bukti bayar
            'order_status' => 'placed', // Status order awal
            'payment_status' => 'processing', // Status pembayaran awal setelah submit bukti
        ]);
        
        // Setelah transaksi dibuat, ubah status galeri menjadi 'sold'
        $galleryItem->status = 'sold';
        $galleryItem->save();

        // Kirim email notifikasi ke Anda (artist/admin)
        // GANTI DENGAN EMAIL ANDA SENDIRI!
        try {
            // Mail::to('ophelia@c23@mhs.istts.ac.id')->send(new NewAdoptionNotification($adoption));
        } catch (\Exception $e) {
            // Jika email gagal, jangan gagalkan seluruh proses, tapi catat errornya
            Log::error('Email sending failed for adoption ID ' . $adoption->adoption_id . ': ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Submission successful!']);
    }
}