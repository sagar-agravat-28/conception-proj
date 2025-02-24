@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">{{ $subcategory->exists ? 'Edit Subcategory' : 'Create Subcategory' }}</h1>
        <form action="{{ $subcategory->exists ? route('subcategories.store', $subcategory) : route('subcategories.store') }}"
            method="POST">
            @csrf
            @if ($subcategory->exists)
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
                    <label class="form-label">Name:</label>
                    <input class="form-control" type="text" name="name" value="{{ old('name', $subcategory->name) }}"
                        required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category:</label>
                    <select class="form-control" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $subcategory->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">{{ $subcategory->exists ? 'Update' : 'Create' }}
                Subcategory</button>
        </form>
    </div>
@endsection
