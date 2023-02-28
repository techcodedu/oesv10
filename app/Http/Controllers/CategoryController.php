<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'nullable',
        ]);
    
        $category = Category::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);
    
        return redirect()->action([CategoryController::class, 'index'])
            ->with('success', 'Category has been created successfully!');
    }
    

    // update
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

       

        $category->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        return redirect()->action([CategoryController::class, 'index'])
        ->with('success', 'Category has been updated successfully!');

    
    }

    public function destroy(Category $category)
    {
        // try {
        //     $category->delete();
        //     return redirect()->action([CategoryController::class, 'index'])->with('success', __('Category deleted successfully.'));
        // } catch (QueryException $e) {
        //     return back()->withErrors(__('Cannot delete category. It has courses linked to it.'));
        // }
        $courses = $category->courses;

        if ($courses->count() > 0) {
            return back()->withErrors(__('Cannot delete category. It has courses linked to it.'));
        }
    
        $category->delete();
    
        return redirect()->action([CategoryController::class, 'index'])
            ->with('success', __('Category successfully deleted.'));

        
    }

    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }
}
