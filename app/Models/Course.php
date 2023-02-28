<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'image', 'category_id', 'instructor_id', 'price','training_hours'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    


    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
