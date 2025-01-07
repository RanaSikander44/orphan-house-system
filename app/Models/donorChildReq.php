<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class donorChildReq extends Model
{
    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function child()
    {
        return $this->belongsTo(child::class, 'child_id');
    }

    
}
