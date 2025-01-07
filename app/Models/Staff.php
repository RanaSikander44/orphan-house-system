<?php

namespace App\Models;

use App\Models\documents_title;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public function documentTitle()
    {
        return $this->belongsTo(documents_title::class, 'title', 'id');
    }


    public function Users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }


}
