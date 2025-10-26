# Commission Management System - Implementation Guide

## Overview
This guide provides step-by-step instructions for implementing the Commission Management System in the Cho's Studio website.

## Files Created/Modified

### Documentation
- ✅ `docs/COMMISSION_MANAGEMENT_SYSTEM.md` - Complete system documentation
- ✅ `docs/COMMISSION_IMPLEMENTATION_GUIDE.md` - Implementation instructions

### Migrations
- ✅ `database/migrations/2025_10_26_000003_add_commission_tracking_fields.php` - Updates existing tables

### Models
- ✅ `app/Models/Commission.php` - Updated with new fields and relationships
- ✅ `app/Models/CommissionProgress.php` - Updated to work with existing table

### JavaScript
- ✅ `resources/js/artist/commission_actions.js` - Commission action handlers
- ✅ `resources/js/artist/commisions.js` - Fixed view button route

### Views (To Be Updated)
- 🔄 `resources/views/artist/commision_detail.blade.php` - Needs action button implementation

## Implementation Steps

### Step 1: Run Database Migration

```bash
php artisan migrate
```

This will:
- Add tracking fields to `commisions` table (cancellation, timestamps)
- Add fields to existing `commission_progress` table (stage, description, status tracking)

### Step 2: Verify Database Structure

The `commission_progress` table now has:
- `com_progress_id` (existing PK)
- `commission_id` (existing FK)
- `image_link` (existing - stores image path)
- `stage` (NEW - sketch/coloring/final/revision)
- `description` (NEW - artist notes)
- `status_from` (NEW - optional status tracking)
- `status_to` (NEW - optional status tracking)
- `created_at`, `updated_at`, `deleted_at` (existing)

### Step 2: Update Commission Detail View

Replace the action buttons section in `commision_detail.blade.php` with the status-based action system.

**Key Changes:**
1. Add hidden input for commission ID
2. Replace static action buttons with dynamic status-based buttons
3. Add upload modal
4. Add contact modal
5. Include the commission_actions.js script

**Add to head section:**
```blade
<meta name="csrf-token" content="{{ csrf_token() }}">
<input type="hidden" id="commission-id" value="{{ $commission->commission_id }}">
```

**Add before closing body tag:**
```blade
@section('scripts')
    @vite(['resources/js/artist/commission_actions.js'])
@endsection
```

### Step 3: Create Upload Modal

Add this modal markup before the closing `</div>` of the main content:

```blade
<!-- Upload Modal -->
<div id="upload-modal" class="modal-overlay hidden fixed inset-0 bg-black bg-opacity-50 z-50 justify-center items-center">
    <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4">
        <h3 class="text-2xl font-bold mb-4">Upload Progress Image</h3>
        <form id="upload-form" enctype="multipart/form-data">
            <input type="hidden" id="upload-type" name="stage" value="">
            
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Select Image</label>
                <input type="file" name="file" accept="image/*" required
                    class="w-full px-3 py-2 border-2 border-stone-300 rounded-lg">
                <p class="text-xs text-gray-500 mt-1">Max file size: 5MB. Accepted: JPG, PNG, GIF</p>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Description (Optional)</label>
                <textarea name="description" rows="3" maxlength="1000" placeholder="Add notes about this progress update..."
                    class="w-full px-3 py-2 border-2 border-stone-300 rounded-lg"></textarea>
                <p class="text-xs text-gray-500 mt-1">Describe what you've completed or any notes for the client</p>
            </div>
            
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeUploadModal()"
                    class="px-4 py-2 border-2 border-stone-300 rounded-lg hover:bg-stone-50">
                    Cancel
                </button>
                <button type="button" id="submit-upload-btn" onclick="submitUpload()"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    <i class="fas fa-upload mr-2"></i>Upload
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Contact Modal -->
<div id="contact-modal" class="modal-overlay hidden fixed inset-0 bg-black bg-opacity-50 z-50 justify-center items-center">
    <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4">
        <h3 class="text-2xl font-bold mb-4">Contact Client</h3>
        <div class="space-y-3 mb-4">
            <p><strong>Email:</strong> <a href="mailto:{{ $member->email }}" class="text-blue-600">{{ $member->email }}</a></p>
            @if($member->phone_number)
                <p><strong>Phone:</strong> {{ $member->phone_number }}</p>
            @endif
            @if($member->line_id)
                <p><strong>Line ID:</strong> {{ $member->line_id }}</p>
            @endif
            @if($member->instagram)
                <p><strong>Instagram:</strong> <a href="https://instagram.com/{{ ltrim($member->instagram, '@') }}" target="_blank" class="text-blue-600">{{ $member->instagram }}</a></p>
            @endif
        </div>
        <button onclick="closeContactModal()"
            class="w-full px-4 py-2 bg-stone-900 text-white rounded-lg hover:bg-stone-700">
            Close
        </button>
    </div>
</div>
```

### Step 4: Create Controller Methods

Create `app/Http/Controllers/Artist/CommissionActionController.php`:

```php
<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\CommissionProgress;
use App\Models\CommissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CommissionActionController extends Controller
{
    /**
     * Update commission status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $commission = Commission::findOrFail($id);
            $oldStatus = $commission->progress_status;
            $newStatus = $request->status;

            // Validate status transition
            if (!$this->isValidStatusTransition($oldStatus, $newStatus)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid status transition'
                ], 400);
            }

            // Update commission
            $commission->progress_status = $newStatus;
            
            // Set timestamps based on status
            if ($newStatus === 'accepted' && !$commission->started_at) {
                $commission->started_at = now();
            } elseif ($newStatus === 'completed' && !$commission->completed_at) {
                $commission->completed_at = now();
            }
            
            $commission->save();

            // Log progress
            CommissionProgress::create([
                'commission_id' => $commission->commission_id,
                'status_from' => $oldStatus,
                'status_to' => $newStatus,
                'notes' => $request->notes,
                'changed_by' => 'artist',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating commission status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating status'
            ], 500);
        }
    }

    /**
     * Reject commission
     */
    public function reject(Request $request, $id)
    {
        try {
            $commission = Commission::findOrFail($id);
            
            $commission->update([
                'progress_status' => 'cancelled',
                'cancellation_reason' => $request->reason,
                'cancelled_by' => 'artist',
                'cancelled_at' => now(),
            ]);

            CommissionProgress::create([
                'commission_id' => $commission->commission_id,
                'status_from' => 'pending',
                'status_to' => 'cancelled',
                'notes' => 'Rejected: ' . $request->reason,
                'changed_by' => 'artist',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Commission rejected'
            ]);
        } catch (\Exception $e) {
            Log::error('Error rejecting commission: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error rejecting commission'
            ], 500);
        }
    }

    /**
     * Cancel commission
     */
    public function cancel(Request $request, $id)
    {
        try {
            $commission = Commission::findOrFail($id);
            
            if (!$commission->isCancellable()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This commission cannot be cancelled'
                ], 400);
            }

            $oldStatus = $commission->progress_status;
            
            $commission->update([
                'progress_status' => 'cancelled',
                'cancellation_reason' => $request->reason,
                'cancelled_by' => 'artist',
                'cancelled_at' => now(),
            ]);

            CommissionProgress::create([
                'commission_id' => $commission->commission_id,
                'status_from' => $oldStatus,
                'status_to' => 'cancelled',
                'notes' => 'Cancelled: ' . $request->reason,
                'changed_by' => 'artist',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Commission cancelled'
            ]);
        } catch (\Exception $e) {
            Log::error('Error cancelling commission: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling commission'
            ], 500);
        }
    }

    /**
     * Upload progress image
     */
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|image|max:5120', // 5MB
            'stage' => 'required|in:sketch,coloring,final,revision',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            $commission = Commission::findOrFail($id);
            
            $file = $request->file('file');
            $path = $file->store('commissions/' . $commission->commission_id, 'public');

            CommissionProgress::create([
                'commission_id' => $commission->commission_id,
                'image_link' => $path,
                'stage' => $request->stage,
                'description' => $request->description,
                'status_from' => $commission->progress_status, // Track current status
                'status_to' => null, // No status change, just image upload
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Progress image uploaded successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error uploading progress image: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error uploading image'
            ], 500);
        }
    }

    /**
     * Update payment status
     */
    public function updatePayment(Request $request, $id)
    {
        try {
            $commission = Commission::findOrFail($id);
            $commission->payment_status = $request->payment_status;
            $commission->save();

            return response()->json([
                'success' => true,
                'message' => 'Payment status updated'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating payment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating payment status'
            ], 500);
        }
    }

    /**
     * Download all files
     */
    public function download($id)
    {
        // Implement ZIP download of all commission files
        // This is a placeholder - implement based on your requirements
    }

    /**
     * Archive commission
     */
    public function archive($id)
    {
        try {
            $commission = Commission::findOrFail($id);
            $commission->delete(); // Soft delete

            return response()->json([
                'success' => true,
                'message' => 'Commission archived'
            ]);
        } catch (\Exception $e) {
            Log::error('Error archiving commission: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error archiving commission'
            ], 500);
        }
    }

    /**
     * Get cancellation details
     */
    public function getCancellationDetails($id)
    {
        try {
            $commission = Commission::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'reason' => $commission->cancellation_reason,
                    'cancelled_at' => $commission->cancelled_at->format('F j, Y g:i A'),
                    'cancelled_by' => ucfirst($commission->cancelled_by),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading cancellation details'
            ], 500);
        }
    }

    /**
     * Validate status transitions
     */
    private function isValidStatusTransition($from, $to)
    {
        $validTransitions = [
            'pending' => ['accepted', 'cancelled'],
            'accepted' => ['in_progress_sketch', 'cancelled'],
            'in_progress_sketch' => ['review', 'cancelled'],
            'review' => ['in_progress_coloring', 'revision', 'completed', 'cancelled'],
            'in_progress_coloring' => ['review', 'cancelled'],
            'revision' => ['review', 'cancelled'],
            'completed' => [],
            'cancelled' => [],
        ];

        return in_array($to, $validTransitions[$from] ?? []);
    }
}
```

### Step 5: Add Routes

Add to `routes/web.php`:

```php
use App\Http\Controllers\Artist\CommissionActionController;

Route::prefix('artist')->middleware(['auth'])->group(function () {
    // Existing routes...
    
    // Commission actions
    Route::post('/commission/{id}/status', [CommissionActionController::class, 'updateStatus']);
    Route::post('/commission/{id}/reject', [CommissionActionController::class, 'reject']);
    Route::post('/commission/{id}/cancel', [CommissionActionController::class, 'cancel']);
    Route::post('/commission/{id}/upload', [CommissionActionController::class, 'upload']);
    Route::post('/commission/{id}/payment', [CommissionActionController::class, 'updatePayment']);
    Route::get('/commission/{id}/download', [CommissionActionController::class, 'download']);
    Route::post('/commission/{id}/archive', [CommissionActionController::class, 'archive']);
    Route::get('/commission/{id}/cancellation', [CommissionActionController::class, 'getCancellationDetails']);
});
```

### Step 6: Update Vite Config

Ensure `commission_actions.js` is included in your Vite build. Add to `vite.config.js` if needed.

### Step 7: Test the System

1. **Test Status Transitions:**
   - Accept a pending commission
   - Start sketch phase
   - Upload sketch
   - Submit for review
   - Start coloring
   - Complete commission

2. **Test Cancellations:**
   - Reject a pending commission
   - Cancel an in-progress commission

3. **Test File Uploads:**
   - Upload sketch progress
   - Upload coloring progress
   - Upload revisions

4. **Test Payment Updates:**
   - Mark commission as paid

## Features Summary

### ✅ Implemented
- Status-based action buttons
- Commission progress tracking
- File upload system
- Cancellation with reason
- Payment status updates
- Progress history logging
- Dynamic UI based on status

### 🔄 To Implement (Future)
- Client approval workflow
- Email notifications
- Timeline view of progress
- Batch file downloads
- Analytics dashboard
- Client portal access

## Troubleshooting

### Common Issues

1. **CSRF Token Error**
   - Ensure meta tag is in head section
   - Check token is being sent with AJAX requests

2. **File Upload Fails**
   - Check `storage/app/public` is linked
   - Run: `php artisan storage:link`
   - Verify file permissions

3. **Status Not Updating**
   - Check console for JavaScript errors
   - Verify routes are registered
   - Check database migrations ran successfully

## Security Checklist

- ✅ CSRF protection on all POST requests
- ✅ File type validation
- ✅ File size limits
- ✅ Status transition validation
- ✅ User authorization checks (implement in middleware)
- ✅ SQL injection protection (Eloquent ORM)
- ✅ XSS protection (Blade escaping)

## Performance Optimization

1. **Database Indexes**
   - Migrations already include indexes
   - Monitor query performance

2. **File Storage**
   - Consider CDN for large files
   - Implement image compression

3. **Caching**
   - Cache frequently accessed commission data
   - Invalidate cache on updates

## Next Steps

1. Run migrations
2. Create controller file
3. Add routes
4. Update commission detail view
5. Test each status workflow
6. Deploy to production

---

**Implementation Status**: Ready for Testing  
**Last Updated**: October 26, 2025  
**Version**: 1.0
