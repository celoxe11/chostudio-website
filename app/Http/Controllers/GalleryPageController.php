<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAdoptionNotification; // Pastikan Anda sudah membuat Mailable ini

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
            // allow up to 5MB since some phones send larger images
            'paymentProof' => 'required|image|mimes:jpeg,png,jpg|max:5120', // max 5MB
        ]);

        if ($validator->fails()) {
            // Log helpful debug info for failing validation (do not log file contents)
            \Log::warning('Adoption validation failed', [
                'errors' => $validator->errors()->toArray(),
                'request_keys' => array_keys($request->all()),
                'has_file' => $request->hasFile('paymentProof'),
            ]);

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

        // Build adoption data matching current DB schema (buyer_*, delivery_*, order/payment enums)
        $adoptionData = [
            'gallery_id' => $galleryItem->gallery_id,
            // front-end sends only email; name/phone not collected here so leave empty/null as appropriate
            'buyer_name' => $request->input('name', ''),
            'buyer_email' => $request->email,
            'buyer_phone' => $request->input('phone', null),
            'price' => $galleryItem->price ?? 0,
            'buyer_message' => $request->input('message', null),
            // delivery_type 'upload_file' indicates buyer uploaded a file (payment proof)
            'delivery_type' => 'upload_file',
            'delivery_file' => $filePath, // store uploaded file path here
            'files_uploaded_at' => $filePath ? now() : null,
            // Use enum values that exist in the DB (order_status default is 'pending', payment_status default is 'unpaid')
            'order_status' => 'pending',
            'payment_status' => 'unpaid',
        ];

        $adoption = Adoption::create($adoptionData);
        
        // Setelah transaksi dibuat, ubah status galeri menjadi 'sold'
        $galleryItem->status = 'sold';
        $galleryItem->save();

        // Kirim email notifikasi ke Anda (artist/admin)
        // GANTI DENGAN EMAIL ANDA SENDIRI!
        try {
            Mail::to('ophelia@c23@mhs.istts.ac.id')->send(new NewAdoptionNotification($adoption));
        } catch (\Exception $e) {
            // Jika email gagal, jangan gagalkan seluruh proses, tapi catat errornya
            \Log::error('Email sending failed for adoption ID ' . $adoption->adoption_id . ': ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Submission successful!']);
    }
}