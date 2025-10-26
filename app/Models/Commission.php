<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'commisions';

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
    ];

    protected $casts = [
        'deadline' => 'date',
        'cancelled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
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
     */
    public function getProgressStatusColorAttribute()
    {
        $colors = [
            'pending' => '#EF4444',
            'accepted' => '#3B82F6',
            'in_progress_sketch' => '#A855F7',
            'in_progress_coloring' => '#C084FC',
            'review' => '#F59E0B',
            'revision' => '#F97316',
            'completed' => '#10B981',
            'cancelled' => '#6B7280',
        ];
        
        return $colors[$this->progress_status] ?? '#6B7280';
    }

    /**
     * Get payment status color
     */
    public function getPaymentStatusColorAttribute()
    {
        $colors = [
            'pending' => '#EF4444',
            'dp' => '#F59E0B',
            'paid' => '#10B981',
            'refunded' => '#6B7280',
        ];
        
        return $colors[$this->payment_status] ?? '#6B7280';
    }
}

