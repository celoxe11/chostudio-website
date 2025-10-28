<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdoptionFileController extends Controller
{
    /**
     * Upload delivery files for an adoption
     */
    public function upload(Request $request, $adoptionId)
    {
        $adoption = Adoption::findOrFail($adoptionId);

        // Validate that payment has been confirmed
        if ($adoption->payment_status !== 'paid') {
            return response()->json([
                'message' => 'Payment must be confirmed before uploading files.'
            ], 422);
        }

        $request->validate([
            'files' => 'required|array|max:10',
            'files.*' => 'file|max:102400|mimes:jpg,jpeg,png,pdf,psd,ai,zip,rar', // 100MB max per file
        ]);

        $uploadedFiles = $adoption->delivery_files ?? [];

        foreach ($request->file('files') as $file) {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            
            // Generate unique filename
            $filename = Str::uuid() . '_' . time() . '.' . $extension;
            
            // Store in private disk
            $path = $file->storeAs(
                "adoption_{$adoption->adoption_id}",
                $filename,
                'adoptions'
            );

            // Save file metadata
            $uploadedFiles[] = [
                'original_name' => $originalName,
                'filename' => $filename,
                'path' => $path,
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'uploaded_at' => now()->toISOString(),
            ];
        }

        $adoption->update([
            'delivery_files' => $uploadedFiles,
            'files_uploaded_at' => now(),
        ]);

        return response()->json([
            'message' => 'Files uploaded successfully.',
            'file_count' => count($uploadedFiles),
        ]);
    }

    /**
     * Delete a specific file
     */
    public function deleteFile(Request $request, $adoptionId)
    {
        $adoption = Adoption::findOrFail($adoptionId);
        $filename = $request->input('filename');

        $files = collect($adoption->delivery_files ?? []);
        $fileToDelete = $files->firstWhere('filename', $filename);

        if (!$fileToDelete) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        // Delete from storage
        Storage::disk('adoptions')->delete($fileToDelete['path']);

        // Remove from database
        $updatedFiles = $files->reject(function ($file) use ($filename) {
            return $file['filename'] === $filename;
        })->values()->toArray();

        $adoption->update([
            'delivery_files' => $updatedFiles,
        ]);

        return response()->json(['message' => 'File deleted successfully.']);
    }

    /**
     * Mark order as delivered and send email
     */
    public function markDelivered(Request $request, $adoptionId)
    {
        $adoption = Adoption::findOrFail($adoptionId);

        // Validate files are uploaded
        if (!$adoption->hasDeliveryFiles()) {
            return response()->json([
                'message' => 'Please upload files before marking as delivered.'
            ], 422);
        }

        $request->validate([
            'delivery_notes' => 'nullable|string|max:1000',
        ]);

        $adoption->update([
            'order_status' => 'delivered',
            'delivered_at' => now(),
            'delivery_notes' => $request->input('delivery_notes'),
        ]);

        // Send delivery email with download link
        \Mail::to($adoption->buyer_email)->send(
            new \App\Mail\AdoptionFilesDelivered($adoption)
        );

        return response()->json([
            'message' => 'Order marked as delivered. Email sent to customer.',
        ]);
    }
}
