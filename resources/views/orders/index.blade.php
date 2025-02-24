@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Orders</h1>
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


    <div id="order-list">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-primary" href="{{ route('orders.create') }}">Add Order</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @include('orders.order-list', ['orders' => $orders])
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchOrders(page);
        });

        function fetchOrders(page) {
            $.ajax({
                url: "/orders?page=" + page,
                success: function(data) {
                    $('#order-list').html(data);
                }
            });
        }
    </script>
@endsection
