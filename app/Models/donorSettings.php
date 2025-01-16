<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class donorSettings extends Model
{
    protected $fillable = [
        'min_dayes_for_req_donors'
    ];
}
