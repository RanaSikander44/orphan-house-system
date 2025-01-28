<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class enquiryFormData extends Model
{

    protected $fillable = ['form_id', 'form_data', 'type', 'sub_type', 'access', 'name', 'label', 'className', 'multiple', 'required' , 'order'];

    public function formName()
    {
        return $this->belongsTo(enquiryForms::class, 'form_id', 'id');
    }

    public function optionsForm()
    {
        return $this->hasMany(enquiryFormOptions::class, 'field_id');
    }
}
