<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    // Set timestamps to false if your roles table doesn't have created_at and updated_at columns
    public $timestamps = false;

    // Define the fillable properties (columns that can be mass-assigned)
    protected $fillable = ['name' , 'guard_name'];

    // You can add relationships, scopes, or other methods here as needed
}
