@extends('layouts.app')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Upload Student Results</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('student_results.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="student_file" class="form-label">Select File</label>
                <input type="file" class="form-control" id="student_file" name="student_file" required>
            </div>
            <button type="submit" class="btn btn-success">Upload</button>
        </form>
    </div>
</div>
@endsection 