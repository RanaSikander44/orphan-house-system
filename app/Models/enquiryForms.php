<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class enquiryForms extends Model
{
    public function formData()
    {
        return $this->hasMany(enquiryFormData::class, 'form_id');
    }
}
