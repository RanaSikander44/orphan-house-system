<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'paid_by', 'id');
    }

    public function renewalType()
    {
        return $this->belongsTo(Payment_renewal::class , 'id' , 'payment_id');
    }
}
