<?php

use App\Http\Controllers\Auth\UsersLoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Certificate;
use App\Http\Controllers\CourseControll;
use App\Http\Controllers\CourseEnrollmentController;
use App\Http\Controllers\CourseInformation;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\OApplication;
use App\Http\Controllers\Reports;
use App\Http\Controllers\Student;
use App\Http\Controllers\StudentPayments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\AssessmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();



Route::get('/register', function () {
    return view('auth.register');
})->name('register');

//  logout
Route::get('/signin', [UsersLoginController::class, 'showLoginForm'])->name('signin');
Route::post('/signin', [UsersLoginController::class, 'signin'])->name('signin');
Route::redirect('/login', '/signin');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::post('/logout', [UsersLoginController::class, 'logout'])->name('logout');
//Admin
//Categories


// Course

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/courses', [CourseControll::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseControll::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseControll::class, 'store'])->name('courses.store');
    // Route::get('/courses/{course}', [CourseControll::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/edit', [CourseControll::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CourseControll::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseControll::class, 'destroy'])->name('courses.destroy');

    Route::get('/courses/instructors', [InstructorController::class, 'index'])->name('admin.instructors.index');
    Route::get('/courses/instructors/create', [InstructorController::class, 'create'])->name('admin.instructors.create');
    Route::post('/courses/instructors', [InstructorController::class, 'store'])->name('admin.instructors.store');
    Route::get('/courses/instructors/{instructor}', [InstructorController::class, 'show'])->name('admin.instructors.show');

    Route::get('/instructors/{instructor}/edit', [InstructorController::class,'edit'])->name('admin.instructors.edit');
    Route::put('/admin/instructors/{instructor}', [InstructorController::class, 'update'])->name('admin.instructors.update');
    
    Route::delete('/courses/instructors/{instructor}', [InstructorController::class, 'destroy'])->name('instructors.destroy');



    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('admin.users');
    Route::get('courseinfo', [CourseInformation::class, 'index'])->name('admin.courseinfo');

    Route::get('application', [OApplication::class, 'index'])->name('admin.oapplication');

    Route::get('/enrollment/{enrollment}', [CourseEnrollmentController::class, 'showEnrollmentDetails'])->name('admin.enrollment.show');
    Route::put('/admin/enrollments/{enrollment}', [CourseEnrollmentController::class, 'updateStatus'])->name('admin.enrollments.updateStatus');
   


Route::get('certificate', [Certificate::class, 'index'])->name('admin.certificate');
Route::get('reports', [Reports::class, 'index'])->name('admin.reports');
Route::get('studentreg', [Student::class, 'registration'])->name('admin.studentregistration');
Route::get('sprofile', [Student::class, 'profile'])->name('admin.studprofile');
Route::get('studentprofile', [StudentPayments::class, 'index'])->name('admin.payments');
});
//   front
Route::get('/', [FrontEndController::class, 'index'])->name('index');
Route::get('/availablecourses', [FrontEndController::class, 'index'])->name('availablecourses');
Route::get('/about', [FrontEndController::class, 'about'])->name('about');
Route::get('/front/signin', [FrontEndController::class, 'index'])->name('front/signin');

Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

Route::group(['middleware' => ['role:student']], function () {
    Route::get('/enroll/{course}', [CourseEnrollmentController::class, 'enroll'])->name('enroll');

     // ASSESSMENT
    Route::get('/assessment/{course}/{user}/{enrollment_type}', [AssessmentController::class, 'showAssessmentForm'])->name('assessment.application');
    Route::post('/assessment', [AssessmentController::class, 'submitApplication'])->name('assessment.submit');


});
Route::get('/courses/category/{id}', [FrontEndController::class, 'category'])->name('courses.category');

// Route::post('/enrollment/{courseId}/{userId}', [CourseEnrollmentController::class, 'storeEnrollment'])->name('enrollment.store');
// Route::post('/enrollment/step3/{enrollment}', [CourseEnrollmentController::class, 'storeStep3'])->name('enrollment.step3');

// Route::get('/enrollment/{courseId}/{userId}/{enrollmentType}', [CourseEnrollmentController::class, 'enroll'])->name('enrollment.enroll');

// Route::get('/courses/{course}/enrollment/{user}', [CourseEnrollmentController::class, 'showEnrollmentForm'])
//     ->name('enrollment.form');

// Route::post('/enrollment/step1/{course}/{user}', [CourseEnrollmentController::class, 'submitStep1'])->name('enrollment.step1.submit');

// // step 2 enrollment route
// Route::post('/enrollment/step2/process/{enrollment}', [CourseEnrollmentController::class, 'storeStep2'])->name('enrollment.step2.submit');
// Route::get('/enrollment/step2/{enrollment}', [CourseEnrollmentController::class, 'step2'])->name('enrollment.step2');

// Route::post('/enrollment/{courseId}/{userId}', [CourseEnrollmentController::class, 'storeEnrollment'])->name('enrollment.store');
// Route::get('/enrollment/{courseId}/{userId}/{enrollmentType}', [CourseEnrollmentController::class, 'enroll'])->name('enrollment.enroll');
// Route::get('/courses/{course}/enrollment/{user}', [CourseEnrollmentController::class, 'showEnrollmentForm'])->name('enrollment.form');
// Route::post('/enrollment/step1/{courseId}/{userId}', [CourseEnrollmentController::class, 'submitStep1'])->name('enrollment.step1.submit');
// Route::get('/enrollment/step2/{enrollment}', [CourseEnrollmentController::class, 'step2'])->name('enrollment.step2');
// Route::post('/enrollment/step2/process/{enrollment}', [CourseEnrollmentController::class, 'storeStep2'])->name('enrollment.step2.submit');
// Route::get('/enrollment/step3/{enrollment}', [CourseEnrollmentController::class, 'showStep3Form'])->name('enrollment.step3');

// Route::post('/enrollment/step3/process/{enrollment}', [CourseEnrollmentController::class, 'storeStep3'])->name('enrollment.step3.submit');
// Route::get('/enrollment/complete/{enrollment}', [CourseEnrollmentController::class, 'complete'])->name('enrollment.complete');
Route::post('/enrollment/{courseId}/{userId}', [CourseEnrollmentController::class, 'storeEnrollment'])->name('enrollment.store');
Route::get('/enrollment/{courseId}/{userId}/{enrollmentType}', [CourseEnrollmentController::class, 'enroll'])->name('enrollment.enroll');
Route::get('/courses/{course}/enrollment/{user}', [CourseEnrollmentController::class, 'showEnrollmentForm'])->name('enrollment.form');
Route::post('/enrollment/step1/{courseId}/{userId}', [CourseEnrollmentController::class, 'submitStep1'])->name('enrollment.step1.submit');
Route::get('/enrollment/step2/{enrollment}', [CourseEnrollmentController::class, 'step2'])->name('enrollment.step2');
Route::post('/enrollment/step2/process/{enrollment}', [CourseEnrollmentController::class, 'storeStep2'])->name('enrollment.step2.submit');
Route::get('/enrollment/step3/{enrollment}', [CourseEnrollmentController::class, 'showStep3Form'])->name('enrollment.step3');
Route::post('/enrollment/step3/process/{enrollment}', [CourseEnrollmentController::class, 'storeStep3'])->name('enrollment.step3.submit');
Route::get('/enrollment/complete/{enrollment}', [CourseEnrollmentController::class, 'complete'])->name('enrollment.complete');
