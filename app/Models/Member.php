<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Member extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * We explicitly set this to 'members' to match your application's design.
     * @var string
     */
    protected $table = 'members';

    /**
     * The attributes that are mass assignable.
     * This allows us to use Member::create() in the registration controller.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'line_id',
        'phone_number',
        'instagram',
        'role', // e.g., 'artist' or 'client'
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     * Ensures the password is automatically hashed before being stored.
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // In modern Laravel, adding 'hashed' here automatically hashes the password attribute
        'password' => 'hashed',
    ];
}
