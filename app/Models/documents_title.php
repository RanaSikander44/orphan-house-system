<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class documents_title extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',        // Add all other fields you want to mass assign
        'document_for', // Add document_for for mass assignment
    ];
}
