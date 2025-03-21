@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Student Results Management</h2>
    <div class="btn-group" role="group">
        <a href="{{ route('student_results.upload') }}" class="btn btn-primary">Upload Results</a>
        <a href="{{ route('student_results.view') }}" class="btn btn-secondary">View Uploaded Results</a>
        <a href="{{ route('student_results.edit') }}" class="btn btn-warning">Edit Results</a>
        <form action="{{ route('student_results.clear') }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete All Results</button>
        </form>
    </div>
</div>
@endsection
