<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
    use HasFactory;

    protected $table = 'adoptions';
    protected $primaryKey = 'adoption_id';
    public $timestamps = true;

    protected $fillable = [
        'gallery_id',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'price',
        'buyer_message',
        'delivery_type',
        'delivery_file',
        'files_uploaded_at',
        'order_status',
        'payment_status'
    ];

    // Relasi ke gallery
    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id', 'gallery_id');
    }
}
