<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class AdoptionDownloadController extends Controller
{
    /**
     * Show download page with all files
     */
    public function index(Request $request, $adoptionId)
    {
        $adoption = Adoption::findOrFail($adoptionId);
        
        // Verify email matches (simple security check)
        $email = $request->query('email');
        
        if ($adoption->buyer_email !== $email) {
            abort(403, 'Unauthorized access.');
        }

        // Check if order is delivered
        if (!in_array($adoption->order_status, ['delivered', 'completed'])) {
            abort(403, 'Files not yet available.');
        }

        // Check if files exist
        if (!$adoption->hasDeliveryFiles()) {
            abort(404, 'No files available for download.');
        }

        return view('adoptions.download', [
            'adoption' => $adoption,
            'files' => $adoption->delivery_files,
        ]);
    }

    /**
     * Download a specific file
     */
    public function download(Request $request, $adoptionId, $filename)
    {
        $adoption = Adoption::findOrFail($adoptionId);
        
        // Verify email
        $email = $request->query('email');
        if ($adoption->buyer_email !== $email) {
            abort(403, 'Unauthorized access.');
        }

        // Find the file
        $files = collect($adoption->delivery_files ?? []);
        $file = $files->firstWhere('filename', $filename);

        if (!$file) {
            abort(404, 'File not found.');
        }

        // Check if file exists in storage
        if (!Storage::disk('adoptions')->exists($file['path'])) {
            abort(404, 'File no longer available.');
        }

        // Return file download response
        return Storage::disk('adoptions')->download(
            $file['path'],
            $file['original_name']
        );
    }

    /**
     * Generate temporary signed download URL
     */
    public static function generateDownloadUrl(Adoption $adoption, $filename, $expiresInDays = 30): string
    {
        return URL::temporarySignedRoute(
            'adoptions.download.file',
            now()->addDays($expiresInDays),
            [
                'adoption' => $adoption->adoption_id,
                'filename' => $filename,
                'email' => $adoption->buyer_email,
            ]
        );
    }

    /**
     * Generate download page URL
     */
    public static function generateDownloadPageUrl(Adoption $adoption): string
    {
        return route('adoptions.download', [
            'adoption' => $adoption->adoption_id,
            'email' => $adoption->buyer_email,
        ]);
    }
}
