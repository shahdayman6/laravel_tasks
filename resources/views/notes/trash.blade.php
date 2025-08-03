
<h2>trash</h2>

@forelse($notes as $note)
    <div style="margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
        <strong>{{ $note->title }}</strong><br>
        <form action="{{ route('notes.restore', $note->id) }}" method="POST" style="display:inline-block;">
            @csrf
            <button type="submit">restore</button>
        </form>

        <form action="{{ route('notes.forceDelete', $note->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit">final deletion</button>
        </form>
    </div>
@empty
    <p style="text-align: center; color: gray;">🗑 empty </p>
@endforelse