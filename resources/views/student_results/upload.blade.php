@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Upload Student Results CSV</h2>
    <form method="POST" action="{{ route('student_results.process') }}" enctype="multipart/form-data">
        @csrf
        <label for="branch">Branch:</label>
        <select name="branch" required>
            @foreach($branches as $branch)
                <option value="{{ $branch }}">{{ $branch }}</option>
            @endforeach
        </select>

        <label for="year">Year:</label>
        <select name="year" required>
            @foreach($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>

        <label for="semester">Semester:</label>
        <select name="semester" required>
            @foreach($semesters as $semester)
                <option value="{{ $semester }}">{{ $semester }}</option>
            @endforeach
        </select>

        <label for="csv_file">CSV File:</label>
        <input type="file" name="csv_file" required accept=".csv">
        <button type="submit" class="btn">Upload and Preview</button>
    </form>
    <br>
    <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>
</div>
@endsection