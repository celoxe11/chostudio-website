<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     * We explicitly set this to 'members' to match your application's design.
     * @var string
     */
    protected $table = 'members';

    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'member_id';

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
