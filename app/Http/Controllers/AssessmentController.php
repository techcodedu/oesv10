<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Assessment;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    //
    public function showAssessmentForm($courseId, $userId, $enrollmentType)
    {
        $course = Course::findOrFail($courseId);
        $user = User::findOrFail($userId);

        // Check if the user meets the assessment requirements for the course
        // ...

        return view('assessment.form', compact('course', 'user'));
    }
    public function submitApplication(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date' => 'required|date',
            'message' => 'required|string',
        ]);

        $courseId = $request->input('course_id');
        $userId = Auth::id();

        $assessment = new Assessment;
        $assessment->user_id = $userId;
        $assessment->course_id = $courseId;
        $assessment->date_scheduled = $validatedData['date'];
        $assessment->status = Assessment::STATUS_PENDING;
        $assessment->result = null;
        $assessment->save();

        // Send email notification to the admin or assessment coordinator
        // ...

        return redirect()->route('home')->with('success', __('Assessment application submitted successfully.'));
    }


}
