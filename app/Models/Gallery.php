<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'gallery';
    protected $primaryKey = 'gallery_id';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'file_format',
        'status',
        'price'
    ];

    // Relasi ke adoption
    public function adoptions()
    {
        return $this->hasMany(Adoption::class, 'gallery_id', 'gallery_id');
    }
}
