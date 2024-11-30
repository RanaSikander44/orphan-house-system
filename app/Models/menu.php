<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class menu extends Model
{
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }
}
