<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildFormData extends Model
{
    public function inputForm()
    {
        return $this->belongsTo(enquiryFormData::class, 'input_id');
    }

}
