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

    public function staffDocs()
    {
        return $this->belongsTo(documents_title::class, 'name', 'id'); // Ensure correct naming
    }
    
}
