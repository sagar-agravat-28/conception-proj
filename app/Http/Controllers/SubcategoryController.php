<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->paginate(100);
        return view('subcategories.index', compact('subcategories'));
    }

    public function addUpdate(Subcategory $subcategory = null)
    {
        if (!$subcategory) {
            $subcategory = new Subcategory();
        }
        $categories = Category::all();
        return view('subcategories.form', compact('subcategory', 'categories'));
    }
    public function store(Request $request, Subcategory $subcategory = null)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($subcategory) {
            $subcategory->update($request->only('name', 'category_id'));
            $message = 'Subcategory updated successfully.';
        } else {
            Subcategory::create($request->only('name', 'category_id'));
            $message = 'Subcategory created successfully.';
        }

        return redirect()->route('subcategories.index')->with('success', $message);
    }
    public function destroy(Subcategory $subcategory)
    {
        // Optionally prevent deletion if subcategory has associated products.
        if ($subcategory->products()->exists()) {
            return redirect()->back()->withErrors(['error' => 'Cannot delete subcategory with products.']);
        }
        $subcategory->delete();

        return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }

}
