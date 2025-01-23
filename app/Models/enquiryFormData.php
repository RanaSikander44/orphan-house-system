<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class enquiryFormData extends Model
{
    public function formName()
    {
       return $this->belongsTo(enquiryForms::class , 'form_id' , 'id');
    }
}
