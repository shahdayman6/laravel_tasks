@extends('notes.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">🗑 Trash Bin</h2>

    @if ($notes->count() > 0)
        <div class="mb-3 text-end">
            <form action="{{ route('notes.restoreAll') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-undo"></i> Restore All
                </button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle shadow-sm">
                <thead class="table-danger text-center">
                    <tr>
                        <th>📝 Title</th>
                        <th>📄 Content</th>
                        <th style="width: 180px;">⚙ Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notes as $note)
                        <tr>
                            <td class="fw-bold text-danger">
                                <i class="fa fa-trash"></i> {{ $note->title }}
                            </td>
                            <td class="text-muted">
                                {{ Str::limit($note->content, 100, '...') }}
                            </td>
                            <td class="text-center">
                                <form action="{{ route('notes.restore', $note->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-undo"></i> Restore
                                    </button>
                                </form>

                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $note->id }}">
                                    <i class="fa fa-trash-alt"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal{{ $note->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $note->id }}" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $note->id }}">Confirm Permanent Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        Are you sure you want to permanently delete "<strong>{{ $note->title }}</strong>"?
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('notes.forceDelete', $note->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $notes->links() }}
        </div>
    @else
        <div class="alert alert-secondary text-center" role="alert">
            🗑 No deleted notes found.
        </div>
    @endif
</div>
@endsection