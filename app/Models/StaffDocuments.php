<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StaffDocuments;


class StaffDocuments extends Model
{
    protected $fillable = [
        'staff_id',        // Add all other fields you want to mass assign
        'title', // Add document_for for mass assignment
        'name',
    ];

    public function staffDocs()
    {
        return $this->belongsTo(DocumentTitlesStaff ::class, 'title');
    }
    
}
