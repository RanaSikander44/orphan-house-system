<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Important import for Authentication
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory;

    // Disable timestamps (created_at, updated_at)
    public $timestamps = false;

    // Add mass-assignable fields
    protected $fillable = ['name', 'email', 'password'];

    /**
     * Automatically hash the password before saving to the database
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Hash the password before saving the user
            if ($user->password) {
                $user->password = Hash::make($user->password);
            }
        });

        static::updating(function ($user) {
            // Hash the password before updating the user
            if ($user->password) {
                $user->password = Hash::make($user->password);
            }
        });
    }
}
