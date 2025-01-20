<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentTitleChild extends Model
{
    protected $fillable = [
        'title',        // Add all other fields you want to mass assign
    ];
}
