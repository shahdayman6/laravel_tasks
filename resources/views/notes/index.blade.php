@extends('notes.layout')

@section('content')

<div class="card mt-5" style="font-size: 1.1rem;">
    <h2 class="card-header text-center">📝 Laravel Notes CRUD</h2>

    <div class="card-body">
        {{-- رسالة نجاح --}}
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- شريط البحث وزر الإنشاء --}}
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <input type="text" id="liveSearch" class="form-control" placeholder="🔍 Search by title...">
            </div>

            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a class="btn btn-success btn-lg px-4 py-2" href="{{ route('notes.create') }}">
                    <i class="fa fa-plus"></i> Create New Note
                </a>
            </div>
        </div>

        {{-- جدول عرض الملاحظات --}}
        <div class="table-responsive" id="notesTable">
            @include('notes.table')
        </div>

        {{-- زر الذهاب للسلة --}}
        <div class="text-end mt-4">
            <a href="{{ route('notes.trash') }}" title="Trash Bin">
                <img src="https://cdn-icons-png.flaticon.com/512/3096/3096673.png" width="35" alt="Trash">
            </a>
        </div>

    </div>
</div>

{{-- سكريبت البحث التلقائي --}}
<script>
    document.getElementById('liveSearch').addEventListener('input', function () {
        let query = this.value;

        fetch("{{ route('notes.liveSearch') }}?search=" + encodeURIComponent(query), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('notesTable').innerHTML = data;
        });
    });
</script>

@endsection