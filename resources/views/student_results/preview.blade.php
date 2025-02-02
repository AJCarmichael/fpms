<!DOCTYPE html>
<html>
<head>
    <title>Preview Student Results</title>
    <style>
        body { font-family: Arial; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 8px; text-align: center; }
        input { width: 100%; box-sizing: border-box; padding: 5px; }
        button { padding: 10px 15px; background: #007BFF; border: none; color: #fff; }
        a { text-decoration: none; color: #007BFF; }
    </style>
</head>
<body>
<div class="container">
    <h2>Preview and Edit Student Results</h2>
    <form method="POST" action="{{ route('student_results.apply') }}">
        @csrf
        <input type="hidden" name="branch" value="{{ $branch }}">
        <input type="hidden" name="year" value="{{ $year }}">
        <input type="hidden" name="semester" value="{{ $semester }}">
        <table>
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
        <button type="submit">Apply Results</button>
    </form>
    <br>
    <a href="{{ route('student_results.upload') }}">Back to Upload</a>
</div>
</body>
</html> 