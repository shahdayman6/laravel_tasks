<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th width="60">No</th>
            <th>Title</th>
            <th>Content</th>
            <th width="240">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($notes as $note)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $note->title }}</td>
                <td>{{ Str::limit($note->content, 50) }}</td>
                <td>
                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="d-inline-block">
                        <a class="btn btn-info btn-sm" href="{{ route('notes.show', $note->id) }}">
                            <i class="fa fa-eye"></i> Show
                        </a>
                        <a class="btn btn-primary btn-sm" href="{{ route('notes.edit', $note->id) }}">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">No notes found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- روابط الصفحات --}}
<div class="d-flex justify-content-center">
    {!! $notes->links() !!}
</div>