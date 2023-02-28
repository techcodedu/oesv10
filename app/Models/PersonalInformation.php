<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    protected $fillable = [
        'fullname',
        'address',
        'age',
        'contact_number',
        'facebook',
        'currently_schooling',
        'employment_status',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public static function createWithEnrollment(Enrollment $enrollment, $data)
    {
        $personalInformation = new self($data);
        $personalInformation->enrollment()->associate($enrollment);
        $personalInformation->save();

        return $personalInformation;
    }
}
