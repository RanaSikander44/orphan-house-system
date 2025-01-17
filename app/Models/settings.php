<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class settings extends Model
{

    use HasFactory;

    protected $fillable = [
        'min_age_of_child',        // Add all other fields you want to mass assign
        'max_age_of_child', // Add document_for for mass assignment
        'charges_of_a_child'
    ];
}
