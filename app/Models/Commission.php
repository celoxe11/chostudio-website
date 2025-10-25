<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $table = 'commisions';

    protected $primaryKey = 'commission_id'; 

    protected $fillable = [
        'member_id',
        'category',
        'description',
        'deadline',
        'price',
        'image_url',
        'payment_status',
        'progress_status',
    ];

    public $timestamps = true;
}
