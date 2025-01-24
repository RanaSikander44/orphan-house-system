<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class enquiryFormOptions extends Model
{
    protected $fillable = ['field_id', 'label', 'value', 'selected', 'order'];

    public function field()
    {
        return $this->belongsTo(EnquiryFormData::class, 'field_id');
    }
}
