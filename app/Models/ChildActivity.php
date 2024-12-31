<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\child;

class ChildActivity extends Model
{
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function child()
    {
        return $this->belongsTo(child::class, 'child_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ChildActivityImages::class, 'activity_id');
    }
    
}
