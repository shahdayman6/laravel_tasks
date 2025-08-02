@extends('notes.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Edit Note</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('notes.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
                 @if ($errors->any())
                <div class="alert alert-danger">
                <strong>Whoops!</strong> في أخطاء لازم تصلحيها:<br><br>
                <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                </ul>
                </div>
                @endif
        <form action="{{ route('notes.update',$note->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="inputTitle" class="form-label"><strong>Title:</strong></label>
                <input 
             type="text" 
             name="title" 
             value="{{ old('title', $note->title) }}"
             class="form-control @error('title') is-invalid @enderror" 
             id="inputTitle" 
             placeholder="Title">
             @error('title')
            <div class="form-text text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
                <label for="inputcontent" class="form-label"><strong>content:</strong></label>
                <textarea 
                class="form-control @error('content') is-invalid @enderror" 
                 style="height:150px" 
                 name="content" 
                 id="inputcontent" 
                  placeholder="Content">{{ old('content', $note->content) }}</textarea>
                  @error('content')
                  <div class="form-text text-danger">{{ $message }}</div>
                   @enderror
            </div>
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Update</button>
        </form>

    </div>
</div>
@endsection