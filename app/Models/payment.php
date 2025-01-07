<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'paid_by', 'id');
    }
}
