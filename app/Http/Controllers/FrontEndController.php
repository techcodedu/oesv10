<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index(){
        $courses = Course::all();
        $categories = Category::all();
        return view('courses',['courses' => $courses, 'categories' => $categories]);
    }

    public function coursesByCategory($categoryId)
    {
        $category = Category::find($categoryId);
        $courses = $category->courses;
        return view('courses', ['courses' => $courses, 'categories' => Category::all()]);
    }

    public function category($categoryId)
    {
        $category = Category::find($categoryId);
        $courses = $category->courses;
        return view('courses', ['courses' => $courses, 'categories' => Category::all()]);
    }
    public function about()
    {
        $categories = Category::all();
        return view('about', ['categories' => $categories]);
    }

  
}