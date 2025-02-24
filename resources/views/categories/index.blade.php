@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">categories</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif


    <div id="catgories-list">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-primary" href="{{ route('categories.create') }}">Add Category</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @include('categories.catgories-list', ['categories' => $categories])
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchCategories(page);
        });

        function fetchCategories(page) {
            $.ajax({
                url: "/categories?page=" + page,
                success: function(data) {
                    $('#catgories-list').html(data);
                }
            });
        }
    </script>
@endsection
