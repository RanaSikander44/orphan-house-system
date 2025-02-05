<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    protected $table = 'dormitory';


    public function mother()
    {
        return $this->belongsTo(User::class, 'nanny_id', 'id');
    }

}
