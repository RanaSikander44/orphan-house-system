<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class child extends Model
{
    public function academicyear()
    {
        return $this->belongsTo(AcademicYear::class, 'campaign_id');
    }

    public function enquiryType()
    {
        return $this->belongsTo(enquiry_types::class, 'enquiry_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function school()
    {
        return $this->belongsTo(Schools::class, 'school_id');
    }
}
