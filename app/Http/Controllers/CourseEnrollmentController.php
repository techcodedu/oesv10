<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\EnrollmentDocument;
use App\Models\PersonalInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Notifications\EnrollmentStatusUpdated;

class CourseEnrollmentController extends Controller
{
  
    //creating new enrollment
    public function enroll($courseId, $userId, $enrollmentType)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // If the user is not authenticated, store the course ID and enrollment type in the session and redirect to the login page
            session(['enrollment_course_id' => $courseId, 'enrollment_type' => $enrollmentType]);
            return redirect()->route('login');
        }

        $course = Course::findOrFail($courseId);
        $user = User::findOrFail($userId);

        $enrollment = Enrollment::enroll($user, $course, $enrollmentType);

        return redirect()->route('enrollment.step2', ['enrollment' => $enrollment->id]);

    }

    // retrieves the course and user
    public function showEnrollmentForm($courseId, $userId)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // If the user is not authenticated, store the course ID in the session and redirect to the login page
            session(['enrollment_course_id' => $courseId]);
            return redirect()->route('login');
        }

        $course = Course::findOrFail($courseId);
        $user = User::findOrFail($userId);
        $enrollmentTypes = Enrollment::pluck('enrollment_type')->toArray();

        return view('enrollment.form', compact('course', 'user', 'enrollmentTypes', 'courseId'));

    }

    // step 1
    public function submitStep1(Request $request, $courseId, $userId, $enrollmentType)
    {
        $validatedData = $request->validate([
            'enrollment_type' => ['required', Rule::in(['scholarship', 'regular_training', 'assessment'])],
        ]);

        $course = Course::findOrFail($courseId);
        $user = User::findOrFail($userId);

        $enrollment = Enrollment::enroll($user, $course, $enrollmentType);

        return redirect()->route('enrollment.step2', ['enrollment' => $enrollment]);
    }

    public function step2(Enrollment $enrollment)
    {

        $course = $enrollment->course;
        $user = $enrollment->user;

        return view('enrollment.step2', compact('course', 'user', 'enrollment'));

    }
    public function showStep3Form(Enrollment $enrollment)
    {
        $personalInformation = $enrollment->personalInformation;
        $enrollment = Enrollment::findOrFail($enrollment->id);

        return view('enrollment.step3', compact('enrollment', 'personalInformation'));
    }

    // step 2
    public function storeStep2(Request $request, Enrollment $enrollment)
    {
        $validatedData = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:18', 'max:100'],
            'contact_number' => ['required', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'currently_schooling' => ['nullable', 'in:yes,no'],
            'employment_status' => ['nullable', 'string', 'max:255'],
        ]);

        // Update the existing Enrollment record with the validated form data
        $enrollment = Enrollment::findOrFail($enrollment->id);
        $enrollment->update($validatedData);

        // Create a new PersonalInformation record and associate it with the existing Enrollment record
        $personalInformation = new PersonalInformation([
            'fullname' => $validatedData['fullname'],
            'address' => $validatedData['address'],
            'age' => $validatedData['age'],
            'contact_number' => $validatedData['contact_number'],
            'facebook' => $validatedData['facebook'],
            'currently_schooling' => $validatedData['currently_schooling'],
            'employment_status' => $validatedData['employment_status'],
        ]);
        $enrollment->personalInformation()->save($personalInformation);

        // Redirect to the next step in the enrollment process
        return redirect()->route('enrollment.step3', ['enrollment' => $enrollment]);

    }

    public function storeStep3(Request $request, Enrollment $enrollment)
    {
        $validatedData = $request->validate([
            'otr_path' => ['required', 'file'],
            'birth_certificate_path' => ['required', 'file'],
            'marriage_certificate_path' => ['nullable', 'file'],
        ]);
    
        // Save each file to a unique path in the storage/app/public directory with original name
        $otrPath = $validatedData['otr_path']->storeAs('enrollment/' . $enrollment->id, $validatedData['otr_path']->getClientOriginalName(), 'public');
        $birthCertificatePath = $validatedData['birth_certificate_path']->storeAs('enrollment/' . $enrollment->id, $validatedData['birth_certificate_path']->getClientOriginalName(), 'public');
        $marriageCertificatePath = $validatedData['marriage_certificate_path']
            ? $validatedData['marriage_certificate_path']->storeAs('enrollment/' . $enrollment->id, $validatedData['marriage_certificate_path']->getClientOriginalName(), 'public')
            : null;
    
        // Create a new EnrollmentDocument record for each file and associate it with the Enrollment record
        $enrollmentDocuments = [
            [
                'name' => 'otr',
                'path' => $otrPath,
                'document_type' => 'otr',
            ],
            [
                'name' => 'birth_certificate',
                'path' => $birthCertificatePath,
                'document_type' => 'birth_certificate',
            ],
            [
                'name' => 'marriage_certificate',
                'path' => $marriageCertificatePath,
                'document_type' => 'marriage_certificate',
            ],
        ];
    
        foreach ($enrollmentDocuments as $enrollmentDocument) {
            $newEnrollmentDocument = new EnrollmentDocument();
            $newEnrollmentDocument->enrollment_id = $enrollment->id;
            $newEnrollmentDocument->name = $enrollmentDocument['name'];
            $newEnrollmentDocument->path = $enrollmentDocument['path'];
            $newEnrollmentDocument->document_type = $enrollmentDocument['document_type'];
            $newEnrollmentDocument->save();
        }
    
        return redirect()->route('enrollment.complete', ['enrollment' => $enrollment->id]);
    }
    

    
    // validating enrollment type input value
    public function storeEnrollment(Request $request, $courseId)
        {
        // Get the currently authenticated user
        $user = Auth::user();

        $validatedData = $request->validate([
            'enrollment_type' => 'required|in:scholarship,regular_training,assessment',
        ]);

        $enrollment = Enrollment::enroll($user, Course::find($courseId), $validatedData['enrollment_type']);
        $enrollment->status = Enrollment::STATUS_IN_REVIEW;
        $enrollment->save();

        return redirect()->route('enrollment.step2', ['enrollment' => $enrollment]);
        }

    public function complete(Enrollment $enrollment)
    {
        return view('enrollment.complete', compact('enrollment'));
    }
    public function showEnrollmentDetails(Enrollment $enrollment)
    {
        // Load the related data for the enrollment
        $enrollment->load('personalInformation', 'course', 'enrollmentDocuments');

        return view('admin.enrollment.show', compact('enrollment'));
    }
    // method on realtime update of the status field of the enrollment
     // method to update the status field of the enrollment
     public function updateStatus(Request $request)
     {
         $enrollment = Enrollment::findOrFail($request->enrollment);
         $newStatus = $request->status;
         $this->updateEnrollmentStatus($enrollment, $newStatus);
         return response()->json(['success' => true]);
     }
     
     // method to update the status field of the enrollment
     private function updateEnrollmentStatus(Enrollment $enrollment, $newStatus)
     {
         $enrollment->status = $newStatus;
         $enrollment->save();
     }
     
    //  notification of enrollment status
    public function sendEnrollmentStatusUpdateNotification(Enrollment $enrollment, $newStatus)
    {
        $enrollment->status = $newStatus;
        $enrollment->save();

        $user = $enrollment->user;
        $user->notify(new EnrollmentStatusUpdated($enrollment));
    }

}
