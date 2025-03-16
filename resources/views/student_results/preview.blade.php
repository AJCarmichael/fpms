@extends('layouts.app')

@section('content')
    <h1>Preview CSV Data</h1>

    <form action="{{ route('student_results.apply') }}" method="POST">
        @csrf
        <input type="hidden" name="branch" value="{{ $branch }}">
        <input type="hidden" name="year" value="{{ $year }}">
        <input type="hidden" name="semester" value="{{ $semester }}">

        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Subject 1 CGPA</th>
                    <th>Subject 2 CGPA</th>
                    <th>Subject 3 CGPA</th>
                    <th>Subject 4 CGPA</th>
                    <th>Subject 5 CGPA</th>
                    <th>Subject 6 CGPA</th>
                    <th>Overall CGPA</th>
                    <th>SGPI</th>
                    <th>KT Flag</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $row)
                    <tr>
                        <td>
                            {{ $row['student_id'] }}
                            <input type="hidden" name="rows[{{ $index }}][student_id]" value="{{ $row['student_id'] }}">
                        </td>
                        <td>
                            <input type="text" name="rows[{{ $index }}][name]" value="{{ $row['name'] }}">
                        </td>
                        <td>
                            {{ $row['subject1_cgpa'] }}
                            <input type="hidden" name="rows[{{ $index }}][subject1_cgpa]" value="{{ $row['subject1_cgpa'] }}">
                        </td>
                        <td>
                            {{ $row['subject2_cgpa'] }}
                            <input type="hidden" name="rows[{{ $index }}][subject2_cgpa]" value="{{ $row['subject2_cgpa'] }}">
                        </td>
                        <td>
                            {{ $row['subject3_cgpa'] }}
                            <input type="hidden" name="rows[{{ $index }}][subject3_cgpa]" value="{{ $row['subject3_cgpa'] }}">
                        </td>
                        <td>
                            {{ $row['subject4_cgpa'] }}
                            <input type="hidden" name="rows[{{ $index }}][subject4_cgpa]" value="{{ $row['subject4_cgpa'] }}">
                        </td>
                        <td>
                            {{ $row['subject5_cgpa'] }}
                            <input type="hidden" name="rows[{{ $index }}][subject5_cgpa]" value="{{ $row['subject5_cgpa'] }}">
                        </td>
                        <td>
                            {{ $row['subject6_cgpa'] }}
                            <input type="hidden" name="rows[{{ $index }}][subject6_cgpa]" value="{{ $row['subject6_cgpa'] }}">
                        </td>
                        <td>
                            {{ $row['overall_semester_cgpa'] }}
                            <input type="hidden" name="rows[{{ $index }}][overall_semester_cgpa]" value="{{ $row['overall_semester_cgpa'] }}">
                        </td>
                        <td>
                            {{ $row['sgpi'] }}
                            <input type="hidden" name="rows[{{ $index }}][sgpi]" value="{{ $row['sgpi'] }}">
                        </td>
                        <td>
                            {{ $row['kt_flag'] }}
                            <input type="hidden" name="rows[{{ $index }}][kt_flag]" value="{{ $row['kt_flag'] }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Apply Results</button>
    </form>
@endsection
