@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">{{ $category->exists ? 'Edit Category' : 'Create Category' }}</h1>

        <form action="{{ $category->exists ? route('categories.store', $category) : route('categories.store') }}"
            method="POST">
            @csrf
            @if ($category->exists)
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
                    <input class="form-control" type="text" name="name" value="{{ old('name', $category->name) }}"
                        required>
                </div>
            </div>

            <button class="btn btn-primary" type="submit">{{ $category->exists ? 'Update' : 'Create' }} Category</button>
        </form>
    </div>


@endsection
