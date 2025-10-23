<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commision extends Model
{
    use HasFactory;

    protected $table = 'commisions';
    protected $primaryKey = 'commision_id';
    protected $fillable = [
        'member_id',
        'category',
        'description',
        'deadline',
        'price',
        'payment_status',
        'progress_status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }
}
