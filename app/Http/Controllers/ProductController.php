<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::orderBy('position')->paginate(10);
        if ($request->ajax()) {
            return view('products.partials.product-list', compact('products'))->render();
        }
        return view('products.index', compact('products'));
    }



    public function store(Request $request)
    {
        // Validate product form input
        $request->validate([
            'title'           => 'required|min:3',
            'description'     => 'required|max:500',
            'amount'          => 'required|numeric|min:0.01',
            'discount_type'   => 'required|in:Flat,Percentage',
            'discount_amount' => 'required|numeric|min:0',
            'category_id'     => 'required|exists:categories,id',
            'subcategory_id'  => 'required|exists:subcategories,id',
        ]);

        $amount        = $request->amount;
        $discount      = $request->discount_amount;
        $discountType  = $request->discount_type;
        $payableAmount = $discountType == 'Percentage' ? $amount - ($amount * $discount / 100) : $amount - $discount;

        Product::create([
            'title'           => $request->title,
            'description'     => $request->description,
            'amount'          => $amount,
            'discount_type'   => $discountType,
            'discount_amount' => $discount,
            'payable_amount'  => $payableAmount,
            'category_id'     => $request->category_id,
            'subcategory_id'  => $request->subcategory_id,
            'position'        => Product::max('position') + 1,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function addUpdate(Product $product)
    {
        $categories    = Category::all();
        $subcategories = [];

        // If editing (i.e., product exists) then load subcategories based on product category_id
        if ($product->exists && $product->category_id) {
            $subcategories = Subcategory::where('category_id', $product->category_id)->get();
        }

        return view('products.form', compact('product', 'categories', 'subcategories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title'           => 'required|min:3',
            'description'     => 'required|max:500',
            'amount'          => 'required|numeric|min:0.01',
            'discount_type'   => 'required|in:Flat,Percentage',
            'discount_amount' => 'required|numeric|min:0',
            'category_id'     => 'required|exists:categories,id',
            'subcategory_id'  => 'required|exists:subcategories,id',
        ]);

        $amount        = $request->amount;
        $discount      = $request->discount_amount;
        $discountType  = $request->discount_type;
        $payableAmount = $discountType == 'Percentage' ? $amount - ($amount * $discount / 100) : $amount - $discount;

        $product->update([
            'title'           => $request->title,
            'description'     => $request->description,
            'amount'          => $amount,
            'discount_type'   => $discountType,
            'discount_amount' => $discount,
            'payable_amount'  => $payableAmount,
            'category_id'     => $request->category_id,
            'subcategory_id'  => $request->subcategory_id,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        // Prevent deletion if product is associated with an active order
        if ($product->orders()->where('status', 'active')->exists()) {
            return back()->withErrors(['error' => 'Cannot delete product associated with an active order']);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function updateOrder(Request $request)
    {
        // Expected request order: order[]=3&order[]=5&order[]=2...
        foreach ($request->order as $position => $id) {
            Product::where('id', $id)->update(['position' => $position]);
        }
        return response()->json(['success' => 'Order updated']);
    }
}
