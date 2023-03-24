<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;


class InstructorController extends Controller
{
    //
    public function index()
    {
        $instructors = Instructor::all();

        return view('admin.instructors.index',compact('instructors'));
    }
    public function show(Instructor $instructor)
    {
        return view('admin.instructors.show',compact('instructor'));
    }

    public function create()
    {
        $areas_of_field_values = [
            'Agriculture and Fisheries',
            'Automotive',
            'Building and Construction',
            'Business Process Outsourcing (BPO)',
            'Electronics',
            'Food and Beverage',
            'Hairdressing and Beauty Care',
            'Health, Social and other Community Development Services',
            'Information and Communications Technology (ICT)',
            'Maritime',
            'Metals and Engineering',
            'Tourism',
            'Transport and Logistics'
        ];
        return view('admin.instructors.create', compact('areas_of_field_values'));

    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'bio' => 'required',
            'area_of_field' => 'required|max:255',
            'image' => 'required|image|max:2048', // validate the image upload
        ]);

        // Truncate the area_of_field input to 255 characters
        $request->merge([
            'area_of_field' => substr($request->area_of_field, 0, 255)
        ]);

        // handle the file upload
        $imageExtension = $request->file('image')->getClientOriginalExtension();
        $uniqueId = uniqid();
        $imageFileName = $uniqueId . '.' . $imageExtension;
        $imagePath = $request->file('image')->storeAs('public/instructor/' . $uniqueId, $imageFileName);
        $imageUrl = asset('storage/instructor/' . $uniqueId . '/' . $imageFileName);

        $instructor = Instructor::create([
            'name' => $request->name,
            'bio' => $request->bio,
            'area_of_field' => $request->area_of_field,
            'image' => 'instructor/' . $uniqueId . '/' . $imageFileName, // save the image path in the instructor model
        ]);

        return redirect()->route('admin.instructors.index')
            ->with('success','Instructor created successfully.');
    }

    public function edit(Instructor $instructor)
    {

        return view('admin.instructors.edit',compact('instructor'));
   
    }
    public function update(Request $request, Instructor $instructor)
    {
        $request->validate([
            'name' => 'required',
            'bio' => 'required',
            'area_of_field' => 'required',
            'image' => 'image|max:2048', // validate the image upload
        ]);

        // handle the file upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $imageUrl = url(Storage::url($imagePath));
        } else {
            $imageUrl = $instructor->image;
        }

        $instructor->update([
            'name' => $request->name,
            'bio' => $request->bio,
            'area_of_field' => $request->area_of_field,
            'image' => $imageUrl, // save the image path in the instructor model
        ]);

        return redirect()->route('admin.instructors.index')
            ->with('success','Instructor updated successfully');
    }

    public function destroy(Instructor $instructor)
    {
        $instructor->delete();

        return redirect()->route('admin.instructors.index')
            ->with('success','Instructor deleted successfully');
    }






}
