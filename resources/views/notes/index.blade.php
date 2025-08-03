@extends('notes.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Laravel CRUD Example</h2>
    <div class="card-body">
        
        @if(session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('notes.create') }}"><i class="fa fa-plus"></i> Create New Note</a>
        </div>

       <form action="{{ route('notes.index') }}" method="GET">
    <input type="text" name="search" placeholder="search" value="{{ request('search') }}">
    <button type="submit">search</button>
        </form>

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Title</th>
                    <th>content</th>
                    <th width="250px">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($notes as $note)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $note->title }}</td>
                        <td>{{ $note->content }}</td>
                        <td>
                            <form action="{{ route('notes.destroy',$note->id) }}" method="POST">
                                <a class="btn btn-info btn-sm" href="{{ route('notes.show',$note->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                                <a class="btn btn-primary btn-sm" href="{{ route('notes.edit',$note->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">There are no data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        {!! $notes->links() !!}

       <div style="width: 100%; text-align: right; margin-top: 10px;">
    <a href="{{ route('notes.trash') }}">
        <img src="https://cdn-icons-png.flaticon.com/512/3096/3096673.png" width="30" alt="trash">
    </a>
       </div>

    </div>
</div>  

@endsection
