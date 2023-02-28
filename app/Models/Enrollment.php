<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    const STATUS_IN_REVIEW = 'inReview';
    const STATUS_IN_PROGRESS = 'inProgress';
    const STATUS_ENROLLED = 'enrolled';
    
    protected $fillable = [
        'user_id',
        'course_id',
        'enrollment_type',
        'status'
    ];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    
    protected $attributes = [
        'status' => self::STATUS_IN_REVIEW
    ];
    
    protected $enums = [
        'status' => [
            self::STATUS_IN_REVIEW,
            self::STATUS_IN_PROGRESS,
            self::STATUS_ENROLLED
        ]
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function personalInformation()
    {
        return $this->hasOne(PersonalInformation::class);
    }

    public function enrollmentDocuments()
    {
        return $this->hasMany(EnrollmentDocument::class);
    }
    
    public function scopeEnrolled($query)
    {
        return $query->where('status', self::STATUS_ENROLLED);
    }
    
    public function scopeInReview($query)
    {
        return $query->where('status', self::STATUS_IN_REVIEW);
    }
    
    public function scopeInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }
    
    public static function enroll(User $user, Course $course, string $enrollmentType)
    {
        $enrollment = new static();
        $enrollment->user_id = $user->id;
        $enrollment->course_id = $course->id;
        $enrollment->enrollment_type = $enrollmentType;
        $enrollment->save();

        return $enrollment;
    }
}
