<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\school_grades;

class Schools extends Model
{
    public function gradeName()
    {
        return $this->belongsTo(school_grades::class, 'grade', 'id');
    }
}
