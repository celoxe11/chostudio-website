<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'commissions';

    protected $primaryKey = 'commission_id';

    protected $fillable = [
        'member_id',
        'category',
        'description',
        'deadline',
        'price',
        'payment_status',
        'progress_status',
        'status_notes',
        'cancellation_reason',
        'cancelled_by',
        'cancelled_at',
        'started_at',
        'completed_at',
        'fully_paid_at',
    ];

    protected $casts = [
        'deadline' => 'date',
        'cancelled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'fully_paid_at' => 'datetime',
    ];

    public $timestamps = true;

    /**
     * Relationship to Member model
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    /**
     * Relationship to CommissionProgress model (images/progress updates)
     */
    public function progressImages()
    {
        return $this->hasMany(CommissionProgress::class, 'commission_id', 'commission_id')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get progress images by stage
     */
    public function getImagesByStage($stage)
    {
        return $this->progressImages()->where('stage', $stage)->get();
    }

    /**
     * Get the latest progress image
     */
    public function getLatestProgressImageAttribute()
    {
        return $this->progressImages()->first();
    }

    /**
     * Check if commission is cancellable
     */
    public function isCancellable()
    {
        return !in_array($this->progress_status, ['completed', 'cancelled']);
    }

    /**
     * Check if commission is editable
     */
    public function isEditable()
    {
        return in_array($this->progress_status, ['pending', 'accepted']);
    }

    /**
     * Get progress status color
     * pending              → 🟡 Yellow (waiting)
     * accepted             → 🔵 Blue (approved)
     * declined             → 🔴 Red (rejected)
     * in_progress_sketch   → 🟣 Purple (working on sketch)
     * in_progress_coloring → 🩷 Pink (working on color)
     * review               → 🩵 Cyan (reviewing)
     * revision             → 🟠 Orange (need changes/revision)
     * completed            → 🟢 Green (done)
     * cancelled            → ⚫ Gray (cancelled)
     */
    public function getProgressStatusColorAttribute()
    {
        $colors = [
            "pending" => "bg-yellow-500", // Yellow - waiting for action
            "accepted" => "bg-blue-500", // Blue - accepted
            "declined" => "bg-red-600", // Dark Red - rejected
            "in_progress_sketch" => "bg-purple-500", // Purple - working on sketch
            "in_progress_coloring" => "bg-pink-500", // Pink - working on color
            "review" => "bg-cyan-500", // Cyan - under review
            "revision" => "bg-orange-500", // Orange - needs changes
            "completed" => "bg-green-500", // Green - done
            "cancelled" => "bg-gray-500", // Gray - cancelled
        ];

        return $colors[$this->progress_status] ?? 'bg-gray-500';
    }

    /**
     * Get progress status text (formatted/display name)
     */
    public function getProgressStatusTextAttribute()
    {
        $texts = [
            'pending' => 'Pending',
            'accepted' => 'Accepted',
            'declined' => 'Declined',
            'in_progress_sketch' => 'Sketching',
            'in_progress_coloring' => 'Coloring',
            'review' => 'In Review',
            'revision' => 'Revision',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        return $texts[$this->progress_status] ?? 'Unknown';
    }

    /**
     * Get payment status color
     */
    public function getPaymentStatusColorAttribute()
    {
        $colors = [
            "pending" => "bg-red-500", // Red - not paid
            "dp" => "bg-amber-500", // Orange - down payment
            "paid" => "bg-green-500", // Green - fully paid
            "refunded" => "bg-gray-500", // Gray - refunded
        ];

        return $colors[$this->payment_status] ?? 'bg-gray-500';
    }

    /**
     * Get payment status text (formatted/display name)
     */
    public function getPaymentStatusTextAttribute()
    {
        $texts = [
            'pending' => 'Unpaid',
            'dp' => 'DP',
            'paid' => 'Paid',
            'refunded' => 'Refunded',
        ];

        return $texts[$this->payment_status] ?? 'Unknown';
    }
}
