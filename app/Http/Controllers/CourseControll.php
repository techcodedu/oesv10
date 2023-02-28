<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\Instructor;

class CourseControll extends Controller
{
    public function index()
    {
        $courses = Course::with('category', 'instructor')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::all();
        $instructors = Instructor::all();
        return view('admin.courses.create', compact('categories', 'instructors'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:courses|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|max:500000', // set limit to 500 MB
            'category_id' => 'required|exists:categories,id',
            'instructor_id' => 'required|exists:instructors,id',
            'price' => 'required|numeric|min:0',
            'training_hours' => 'nullable|numeric|min:0',
        ]);

     
        

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $imagePath = $image->storeAs('courses', $imageName, 'public');
        }

        $course = Course::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'image' => $imagePath,
            'category_id' => $validatedData['category_id'],
            'instructor_id' => $validatedData['instructor_id'],
            'price' => $validatedData['price'],
            'training_hours' => $validatedData['training_hours'],
        ]);
        

        return redirect()->action([CourseControll::class, 'index'])
            ->with('success', 'Course has been created successfully!');
    }
    public function edit(Course $course)
{
    $categories = Category::all();
    $instructors = Instructor::all();

    return view('admin.courses.edit', compact('course', 'categories', 'instructors'));
}

public function update(Request $request, Course $course)
{
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'description' => 'nullable',
        'image' => 'nullable|image|max:500000', // set limit to 500 MB
        'category_id' => 'required|exists:categories,id',
        'instructor_id' => 'required|exists:instructors,id',
        'training_hours' => 'nullable|numeric|min:0',
    ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('public/images');
        $validatedData['image'] = str_replace('public/', 'storage/', $imagePath);
    }

    $course->update($validatedData);

    return redirect()->action([CourseControll::class, 'index'])
        ->with('success', 'Course has been updated successfully!');
}

public function destroy(Course $course)
{
    $course->delete();

    return redirect()->action([CourseControll::class, 'index'])
        ->with('success', 'Course has been deleted successfully!');
}

}
