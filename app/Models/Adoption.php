<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adoption extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'adoptions';
    protected $primaryKey = 'adoption_id';
    public $timestamps = true;

    protected $fillable = [
        'gallery_id',
        'email',
        'payment_confirmation',
        'order_status',
        'payment_status',
    ];

    // Relasi ke Gallery
    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id', 'gallery_id');
    }
}
