<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use App\Models\Qualification;


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
        $qualifications = $instructor->qualifications;

        return view('admin.instructors.partials.details',compact('instructor','qualifications'));
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
        $default_qualifications = [
            'Baking and Pastry Production NC II',
            'Bartending NC II',
            'Beauty Care Services NC II',
            'Bookkeeping NC III',
            'Carpentry NC II',
            'Commercial Cooking NC II',
            'Computer Systems Servicing NC II',
            'Consumer Electronics Servicing NC II',
            'Cookery NC II',
            'Dressmaking NC II',
            'Driving NC II',
            'Electrical Installation and Maintenance NC II',
            'Electronics Products Assembly and Servicing NC II',
            'Food and Beverage Services NC II',
            'Front Office Services NC II',
            'Hairdressing NC II',
            'Health Care Services NC II',
            'Housekeeping NC II',
            'Masonry NC II',
            'Mechanical Drafting NC II',
            'Mechatronics Servicing NC II',
            'Motorcycle/Small Engine Servicing NC II',
            'Plumbing NC II',
            'Programming NC IV',
            'Refrigeration and Air Conditioning Servicing NC II',
            'Tourism Promotion Services NC II',
            'Trainers Methodology Level I',
            'Welding NC II',
            'Shielded Metal Arc Welding (SMAW) NC I',
            'Shielded Metal Arc Welding (SMAW) NC II'
        ];
        

        return view('admin.instructors.create', compact('areas_of_field_values','default_qualifications'));

    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'bio' => 'required',
            'area_of_field' => 'required|max:255',
            'image' => 'required|image|max:2048', // validate the image upload
            'qualifications' => 'required|array|min:1'
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

        // Filter out any null or empty values in the qualifications array
        $validQualifications = array_filter($request->qualifications, function ($title) {
            return !is_null($title) && trim($title) !== '';
        });

        // insert the qualification
        $qualifications = array_map(function ($title) use ($instructor) {
            return [
                'instructor_id' => $instructor->id,
                'title' => $title,
            ];
        }, $validQualifications);
        
        Qualification::insert($qualifications);

        return redirect()->route('admin.instructors.index')
            ->with('success','Instructor created successfully.');
    }
    // edit
    public function edit(Instructor $instructor)
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
        $default_qualifications = [
            'Baking and Pastry Production NC II',
            'Bartending NC II',
            'Beauty Care Services NC II',
            'Bookkeeping NC III',
            'Carpentry NC II',
            'Commercial Cooking NC II',
            'Computer Systems Servicing NC II',
            'Consumer Electronics Servicing NC II',
            'Cookery NC II',
            'Dressmaking NC II',
            'Driving NC II',
            'Electrical Installation and Maintenance NC II',
            'Electronics Products Assembly and Servicing NC II',
            'Food and Beverage Services NC II',
            'Front Office Services NC II',
            'Hairdressing NC II',
            'Health Care Services NC II',
            'Housekeeping NC II',
            'Masonry NC II',
            'Mechanical Drafting NC II',
            'Mechatronics Servicing NC II',
            'Motorcycle/Small Engine Servicing NC II',
            'Plumbing NC II',
            'Programming NC IV',
            'Refrigeration and Air Conditioning Servicing NC II',
            'Tourism Promotion Services NC II',
            'Trainers Methodology Level I',
            'Welding NC II',
            'Shielded Metal Arc Welding (SMAW) NC I',
            'Shielded Metal Arc Welding (SMAW) NC II'
        ];
        $qualifications = $instructor->qualifications;
        return view('admin.instructors.edit', compact('instructor', 'areas_of_field_values', 'qualifications','default_qualifications'));
    }
    public function update(Request $request, Instructor $instructor)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'required|string',
            'area_of_field' => 'required|string|max:255',
            'qualifications' => 'required|array|min:1',
            'qualifications.*.title' => 'required|string|max:255',
            'image' => 'sometimes|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update the other fields ...
        $instructorData = [
            'name' => $request->name,
            'bio' => $request->bio,
            'area_of_field' => $request->area_of_field,
        ];

        // Handle the file upload if a new image is provided
        if ($request->hasFile('image')) {
            $imageExtension = $request->file('image')->getClientOriginalExtension();
            $uniqueId = uniqid();
            $imageFileName = $uniqueId . '.' . $imageExtension;
            $imagePath = $request->file('image')->storeAs('public/instructor/' . $uniqueId, $imageFileName);
            $imageUrl = asset('storage/instructor/' . $uniqueId . '/' . $imageFileName);

            $instructorData['image'] = 'instructor/' . $uniqueId . '/' . $imageFileName; // update the image path in the instructor model
        }

        $instructor->update($instructorData);

        // Update qualifications
        $newQualifications = collect($request->qualifications);
        $instructor->qualifications()->delete();
        $instructor->qualifications()->createMany(
            $newQualifications->map(function ($qualification) {
                return ['title' => $qualification['title']];
            })->toArray()
        );

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor updated successfully');
    }

    public function destroy(Instructor $instructor)
    {
        if ($instructor->courses->count() > 0) {
            return redirect()->route('admin.instructors.index')
                ->with('error', 'Instructor cannot be deleted because they are assigned to one or more courses.');
        }

        $instructor->delete();

        return redirect()->route('admin.instructors.index')
            ->with('success', 'Instructor deleted successfully');
    }








}
