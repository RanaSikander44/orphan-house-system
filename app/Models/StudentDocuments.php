<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\documents_title;

class StudentDocuments extends Model
{
    protected $table = 'student_documents'; // Define the table name explicitly
    protected $fillable = [
        'title',       // Title of the document
        'name',   // Path where the document is stored
        'student_id',
    ];


    public function documentTitle()
    {
        return $this->belongsTo(documents_title ::class, 'title', 'id');
    }


}
