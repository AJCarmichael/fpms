@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Preview and Edit Student Results</h2>
    <form method="POST" action="{{ route('student_results.apply') }}">
        @csrf
        <input type="hidden" name="branch" value="{{ $branch }}">
        <input type="hidden" name="year" value="{{ $year }}">
        <input type="hidden" name="semester" value="{{ $semester }}">
        <table class="table">
            <thead>
                <tr>
                    @if(count($data) > 0)
                        @foreach(array_keys($data[0]) as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $row)
                    <tr>
                        @foreach($row as $key => $value)
                            <td>
                                <input type="text" name="rows[{{ $index }}][{{ $key }}]" value="{{ $value }}">
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn">Apply Results</button>
    </form>
    <br>
    <a href="{{ route('student_results.upload') }}" class="btn">Back to Upload</a>
</div>
@endsection