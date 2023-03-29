<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'title',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}