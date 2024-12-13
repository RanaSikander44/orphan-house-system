<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class child extends Model
{
    public function academicyear()
    {
        return $this->belongsTo(AcademicYear::class, 'campaign_id');
    }
}
