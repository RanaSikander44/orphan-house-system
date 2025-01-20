<?php

namespace App\Models;
use App\Models\documents_title;

use Illuminate\Database\Eloquent\Model;

class child_documents extends Model
{

    protected $fillable = [
        'title',       // Title of the document
        'name',   // Path where the document is stored
        'child_id',
    ];


    public function documentTitle()
    {
        return $this->belongsTo(DocumentTitleChild::class, 'title');
    }

}
