<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Important import for Authentication
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, HasRoles;

    // Disable timestamps (created_at, updated_at)
    public $timestamps = false;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',  // Add role field to fillable as well
    ];
    // Add mass-assignable fields
    // protected $fillable = ['name', 'email', 'password','role'];
    protected $table = 'users';
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

        // static::updating(function ($user) {
        //     // Hash the password before updating the user
        //     if (!empty($user->password)) {
        //         $user->password = Hash::make($user->password);
        //     }
        // });
    }

    public function role()
    {
        return $this->belongsTo(Role::class , 'role_id');
    }

}
