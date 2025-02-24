@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Product</h1>
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

    <div id="product-list">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-primary" href="{{ route('products.create') }}">Add Product</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @include('products.product-list', ['products' => $products])
                </div>
            </div>
        </div>
    </div>


    <script>
        // AJAX Pagination
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchProducts(page);
        });

        function fetchProducts(page) {
            $.ajax({
                url: "/products?page=" + page,
                success: function(data) {
                    $('#product-list').html(data);
                }
            });
        }

        // Drag-and-Drop Sorting
        $(function() {
            $("#sortable").sortable({
                update: function(event, ui) {
                    let order = $(this).sortable('toArray', {
                        attribute: 'data-id'
                    });
                    $.post("/update-order", {
                        order: order
                    }, function(response) {
                        console.log(response.success);
                    });
                }
            });
        });
    </script>
@endsection
