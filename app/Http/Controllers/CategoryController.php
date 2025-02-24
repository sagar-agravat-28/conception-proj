<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Subcategory;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::paginate(100);
        return view('categories.index', compact('categories'));
    }

    public function addUpdate(Category $category = null)
    {
        // If no category is passed, create an empty instance for the form.
        if (!$category) {
            $category = new Category();
        }
        return view('categories.form', compact('category'));
    }

    public function store(Request $request, Category $category = null)
    {
        // If $category is null then it's a create action.
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        if ($category) {
            // Update existing category
            $category->update($request->only('name'));
            $message = 'Category updated successfully.';
        } else {
            // Create new category
            Category::create($request->only('name'));
            $message = 'Category created successfully.';
        }

        return redirect()->route('categories.index')->with('success', $message);
    }


    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->withErrors(['error' => 'Cannot delete category with products']);
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();
        // Return as JSON so AJAX can rebuild the dropdown options
        return response()->json($subcategories);
    }
}
