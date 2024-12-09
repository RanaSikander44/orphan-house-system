<?php

namespace App\Models;

use App\Models\documents_title;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    //

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function documentTitle()
    {
        return $this->belongsTo(documents_title ::class, 'title', 'id');
    }
    
}
