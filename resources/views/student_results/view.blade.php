@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Uploaded Student Results</h2>
    <table class="table">
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
    <br>
    <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>
</div>
@endsection