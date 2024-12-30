<?php

namespace App\Models;

use App\Http\Controllers\admin\StaffController;
use Illuminate\Database\Eloquent\Model;

class nannyChilds extends Model
{

    protected $fillable = [
        'nanny_id',
        'child_id',
        'school_id',
    ];

    public function child()
    {
        return $this->belongsTo(child::class, 'child_id', 'id');
    }
}
