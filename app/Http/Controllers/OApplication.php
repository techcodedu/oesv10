<?php

namespace App\Http\Controllers;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class OApplication extends Controller
{
    //
    public function index()
    {
        // Get the count of enrollments in each status
        $enrollmentCounts = [
            'inReview' => Enrollment::inReview()->count(),
            'inProgress' => Enrollment::inProgress()->count(),
            'enrolled' => Enrollment::enrolled()->count(),
        ];

        // Get the latest enrollment
        $latestEnrollment = Enrollment::latest()->with(['course', 'user'])->first();

        // Get the total number of enrollments
        $totalEnrollments = Enrollment::count();

        // Get all enrollments with their associated course and user data
        $enrollments = Enrollment::with(['course', 'user'])->paginate(10);

        // Pass the data to the view
        return view('admin.oapplication', compact('enrollmentCounts', 'latestEnrollment', 'totalEnrollments', 'enrollments'));
    }


}
