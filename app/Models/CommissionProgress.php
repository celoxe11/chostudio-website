<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class CommissionProgress extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'commission_progress';
    
    protected $primaryKey = 'com_progress_id';

    protected $fillable = [
        'commission_id',
        'image_link',
        'stage',
        'description',
        'status_from',
        'status_to',
    ];

    public $timestamps = true;

    /**
     * Get the commission that owns the progress entry
     */
    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id', 'commission_id');
    }

    /**
     * Get the full URL for the image
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_link) return null;
        
        // If it's already a full URL, return as is
        if (str_starts_with($this->image_link, 'http')) {
            return $this->image_link;
        }
        
        // Otherwise, get from storage
        return Storage::url($this->image_link);
    }

    /**
     * Get stage label
     */
    public function getStageLabelAttribute()
    {
        $labels = [
            'sketch' => 'Sketch Phase',
            'coloring' => 'Coloring Phase',
            'final' => 'Final Artwork',
            'revision' => 'Revision',
        ];
        
        return $labels[$this->stage] ?? $this->stage;
    }

    /**
     * Get formatted status change description
     */
    public function getStatusChangeAttribute()
    {
        if (!$this->status_from && !$this->status_to) {
            return 'Progress update';
        }
        
        $from = $this->status_from ? $this->getStatusLabel($this->status_from) : 'New';
        $to = $this->status_to ? $this->getStatusLabel($this->status_to) : '';
        
        if (!$to) return "Progress update - {$this->stage_label}";
        
        return "{$from} → {$to}";
    }

    /**
     * Get human-readable status label
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Pending',
            'accepted' => 'Accepted',
            'in_progress_sketch' => 'In Progress (Sketch)',
            'in_progress_coloring' => 'In Progress (Coloring)',
            'review' => 'In Review',
            'revision' => 'Revision',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
        
        return $labels[$status] ?? $status;
    }
    
    /**
     * Delete image from storage when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($progress) {
            if ($progress->image_link && Storage::exists($progress->image_link)) {
                Storage::delete($progress->image_link);
            }
        });
    }
}
