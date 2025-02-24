
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
                <th>Category</th>
                <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($subcategories as $sub)
        <tr>
            <td>{{ $sub->id }}</td>
            <td>{{ $sub->name }}</td>
            <td>{{ $sub->category->name ?? 'N/A' }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('subcategories.edit', $sub) }}">Edit</a>
                <form action="{{ route('subcategories.destroy', $sub) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit" onclick="return confirm('Delete this subcategory?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div>
{{ $subcategories->links() }}
</div>
