@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">{{ $product->exists ? 'Edit Product' : 'Create Product' }}</h1>
        <form action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}" method="POST"
            class="needs-validation" novalidate>
            @csrf
            @if ($product->exists)
                @method('PUT')
            @endif
            @if ($errors->any())
                <div>
                    @foreach ($errors->all() as $error)
                        <p class="text-danger">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Title:</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title', $product->title) }}"
                        required minlength="3">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Description:</label>
                    <textarea class="form-control" name="description" required maxlength="500">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Amount:</label>
                    <input type="number" class="form-control" step="0.01" name="amount" id="amount"
                        value="{{ old('amount', $product->amount) }}" required min="0.01">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Discount Type:</label>
                    <select class="form-control" name="discount_type" id="discount_type" required>
                        <option value="Flat"
                            {{ old('discount_type', $product->discount_type) == 'Flat' ? 'selected' : '' }}>Flat</option>
                        <option value="Percentage"
                            {{ old('discount_type', $product->discount_type) == 'Percentage' ? 'selected' : '' }}>Percentage
                        </option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Discount Amount:</label>
                    <input type="number" class="form-control" step="0.01" name="discount_amount" id="discount"
                        value="{{ old('discount_amount', $product->discount_amount) }}" required min="0">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Payable Amount:</label>
                    <input type="text" class="form-control" id="payable_amount" name="payable_amount"
                        value="{{ old('payable_amount', $product->payable_amount) }}" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category:</label>
                    <select class="form-control" name="category_id" id="category" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Subcategory:</label>
                    <select class="form-control" name="subcategory_id" id="subcategory" required>
                        <option value="">Select Subcategory</option>
                        @foreach ($subcategories as $subcat)
                            <option value="{{ $subcat->id }}"
                                {{ old('subcategory_id', $product->subcategory_id) == $subcat->id ? 'selected' : '' }}>
                                {{ $subcat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ $product->exists ? 'Update' : 'Create' }}
                Product</button>
        </form>
    </div>

    <script>
        // CSRF setup for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Dynamic subcategory loading when category changes
        $('#category').change(function() {
            let categoryId = $(this).val();
            $.ajax({
                url: `{{ route('get.subcategories', ':category') }}`.replace(':category', categoryId),
                type: 'GET',
                success: function(data) {
                    let options = '<option value="">Select Subcategory</option>';
                    $.each(data, function(index, subcat) {
                        options += `<option value="${subcat.id}">${subcat.name}</option>`;
                    });
                    $('#subcategory').html(options);
                }
            });
        });

        // Real-time calculation for payable amount
        $('#amount, #discount, #discount_type').on('input change', function() {
            let amount = parseFloat($('#amount').val()) || 0;
            let discount = parseFloat($('#discount').val()) || 0;
            let type = $('#discount_type').val();
            let payable = type === 'Percentage' ? amount - (amount * discount / 100) : amount - discount;
            $('#payable_amount').val(payable.toFixed(2));
        });
    </script>
@endsection
