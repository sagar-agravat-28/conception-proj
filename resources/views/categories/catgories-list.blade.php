<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>name</th>
            <th>Subcategories</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $cat)
            <tr>
                <td>{{ $cat->id }}</td>
                <td>{{ $cat->name }}</td>
                <td>
                    @if ($cat->subcategories->count())
                        <ul>
                            @foreach ($cat->subcategories as $sub)
                                <li>{{ $sub->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <em>No subcategories</em>
                    @endif
                </td>
                <td>
                    <a class="btn btn-primary" href="{{ route('categories.edit', $cat) }}">Edit</a>
                    <form action="{{ route('categories.destroy', $cat) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit" onclick="return confirm('Delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div>
    {{ $categories->links() }}
</div>
