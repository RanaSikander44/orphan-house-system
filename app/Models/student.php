<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'year_id',
        'admission_date',
        'caste',
        'admission_no',
        'gender',
        'dob',
        'email',
        'phone_no',
        'current_address',
        'permanent_address',
        'blood_group',
        'height',
        'phone_no',
        'weight',
    ];
}

