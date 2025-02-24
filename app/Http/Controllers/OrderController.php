<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $orders = Order::with('product', 'user')->orderBy('created_at', 'desc')->paginate(10);
        if ($request->ajax()) {
            return view('orders.partials.order-list', compact('orders'))->render();
        }
        return view('orders.index', compact('orders'));
    }

    public function addUpdate(Order $order = null)
    {
        // If no order is provided, create an empty instance
        if (!$order) {
            $order = new Order();
        }
        // Load products for the dropdown list
        $products = Product::all();
        return view('orders.form', compact('order', 'products'));
    }

    public function store(Request $request, Order $order = null)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'status'     => 'required|in:active,completed,cancelled',
        ]);

        // Get input data and optionally attach logged in user
        $data = $request->only('product_id', 'status');
        $data['user_id'] = Auth::id();

        if ($order) {
            // Update existing order
            $order->update($data);
            $message = 'Order updated successfully.';
        } else {
            // Create new order
            Order::create($data);
            $message = 'Order created successfully.';
        }
        return redirect()->route('orders.index')->with('success', $message);
    }

    public function destroy(Order $order)
    {
        if ($order->status === 'active') {
            return redirect()->back()->withErrors(['error' => 'Cannot delete an active order.']);
        }
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
