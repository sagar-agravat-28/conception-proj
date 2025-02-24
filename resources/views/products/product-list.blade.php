
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Payable</th>
                        <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="sortable">
                    @foreach($products as $product)
                    <tr data-id="{{ $product->id }}">
                        <td>{{ $product->position }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->amount }}</td>
                        <td>{{ $product->payable_amount }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('products.edit', $product) }}">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
            </table>

<div>
    {{ $products->links() }}
</div>
