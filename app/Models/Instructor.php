<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'area_of_field', // add the new field here
        'image'
    ];

    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }
    // Inside the Instructor model

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

}
