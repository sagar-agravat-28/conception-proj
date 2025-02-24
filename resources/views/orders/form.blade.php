@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">{{ $order->exists ? 'Edit Order' : 'Create Order' }}</h1>
        <form action="{{ $order->exists ? route('orders.store', $order) : route('orders.store') }}" method="POST">
            @csrf
            @if ($order->exists)
                @method('PUT')
            @endif
            @if ($errors->any())
                <div>
                    @foreach ($errors->all() as $error)
                        <p class="text-danger">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Product:</label>
                    <select class="form-control" name="product_id" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                {{ old('product_id', $order->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Status:</label>
                    <select class="form-control" name="status" required>
                        <option value="active" {{ old('status', $order->status) == 'active' ? 'selected' : '' }}>Active
                        </option>
                        <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>
                            Completed</option>
                        <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>
                            Cancelled</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">{{ $order->exists ? 'Update' : 'Create' }} Order</button>
        </form>
    </div>
@endsection
