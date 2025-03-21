@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Uploaded Student Results</h2>
    <div class="btn-group" role="group">
        <a href="{{ route('student_results.upload') }}" class="btn btn-primary">Upload Results</a>
        <a href="{{ route('student_results.edit') }}" class="btn btn-warning">Edit Results</a>
        <form action="{{ route('student_results.clear') }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete All Results</button>
        </form>
    </div>
    <table class="table table-responsive">
        <thead>
            <tr>
                <th>Roll Number</th>
                <th>Name</th>
                <th>Branch</th>
                <th>Year</th>
                <th>Semester</th>
                <th>Subject 1 CGPA</th>
                <th>Subject 2 CGPA</th>
                <th>Subject 3 CGPA</th>
                <th>Subject 4 CGPA</th>
                <th>Subject 5 CGPA</th>
                <th>Subject 6 CGPA</th>
                <th>Overall Semester CGPA</th>
                <th>SGPI</th>
                <th>KT Flag</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
            <tr>
                <td>{{ $result->student->roll_no }}</td>
                <td>{{ $result->student->name }}</td>
                <td>{{ $result->branch }}</td>
                <td>{{ $result->year }}</td>
                <td>{{ $result->semester }}</td>
                <td>{{ $result->subject1_cgpa }}</td>
                <td>{{ $result->subject2_cgpa }}</td>
                <td>{{ $result->subject3_cgpa }}</td>
                <td>{{ $result->subject4_cgpa }}</td>
                <td>{{ $result->subject5_cgpa }}</td>
                <td>{{ $result->subject6_cgpa }}</td>
                <td>{{ $result->overall_semester_cgpa }}</td>
                <td>{{ $result->sgpi }}</td>
                <td>{{ $result->kt_flag ? 'Yes' : 'No' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
</div>
@endsection