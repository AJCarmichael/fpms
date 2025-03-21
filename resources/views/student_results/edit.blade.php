@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Student Results</h2>
    <form action="{{ route('student_results.update') }}" method="POST">
        @csrf
        @method('PUT')
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>Student ID</th>
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr>
                    <td><input type="text" name="rows[{{ $result->id }}][student_id]" value="{{ $result->student_id }}" readonly></td>
                    <td><input type="text" name="rows[{{ $result->id }}][name]" value="{{ $result->student->name }}" readonly></td>
                    <td><input type="text" name="rows[{{ $result->id }}][branch]" value="{{ $result->branch }}"></td>
                    <td><input type="text" name="rows[{{ $result->id }}][year]" value="{{ $result->year }}"></td>
                    <td><input type="text" name="rows[{{ $result->id }}][semester]" value="{{ $result->semester }}"></td>
                    <td><input type="text" name="rows[{{ $result->id }}][subject1_cgpa]" value="{{ $result->subject1_cgpa }}"></td>
                    <td><input type="text" name="rows[{{ $result->id }}][subject2_cgpa]" value="{{ $result->subject2_cgpa }}"></td>
                    <td><input type="text" name="rows[{{ $result->id }}][subject3_cgpa]" value="{{ $result->subject3_cgpa }}"></td>
                    <td><input type="text" name="rows[{{ $result->id }}][subject4_cgpa]" value="{{ $result->subject4_cgpa }}"></td>
                    <td><input type="text" name="rows[{{ $result->id }}][subject5_cgpa]" value="{{ $result->subject5_cgpa }}"></td>
                    <td><input type="text" name="rows[{{ $result->id }}][subject6_cgpa]" value="{{ $result->subject6_cgpa }}"></td>
                    <td><input type="text" name="rows[{{ $result->id }}][overall_semester_cgpa]" value="{{ $result->overall_semester_cgpa }}"></td>
                    <td><input type="text" name="rows[{{ $result->id }}][sgpi]" value="{{ $result->sgpi }}"></td>
                    <td><input type="checkbox" name="rows[{{ $result->id }}][kt_flag]" {{ $result->kt_flag ? 'checked' : '' }}></td>
                    <td>
                        <form action="{{ route('student_results.delete', $result->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection
