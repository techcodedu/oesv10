<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EnrollmentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'document_type',
        'file_path',
    ];

    public function enrollment()
    {
            return $this->belongsTo(Enrollment::class);
    }

    // public function uploadDocument($documentType, $file)
    // {
    //     // Generate a unique filename
    //     $filename = uniqid() . '_' . $file->getClientOriginalName();

    //     // Save the file to a subdirectory of the public directory
    //     $filePath = $file->storeAs('enrollment_documents/' . $documentType, $filename, 'public');

    //     // Update the file_path attribute of the model
    //     $this->file_path = $filePath;

    //     // Update the document_type attribute of the model
    //     $this->document_type = $documentType;

    //     // Save the model to the database
    //     $this->save();
    // }
    public function uploadDocument($documentType, $file)
    {
        // Generate a unique filename
        $filename = uniqid() . '_' . $file->getClientOriginalName();

        // Save the file to a subdirectory of the public directory
        $filePath = $file->storeAs('enrollment_documents/' . $documentType, $filename, 'public');

        // Update the file_path attribute of the model
        $this->file_path = $filePath;

        // Update the document_type attribute of the model
        $this->document_type = $documentType;

        // Save the original filename of the file in the name attribute of the model
        $this->name = $file->getClientOriginalName();

        // Save the model to the database
        $this->save();
    }

}
