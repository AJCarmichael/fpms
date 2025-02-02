<!DOCTYPE html>
<html>
<head>
    <title>Upload Student Results</title>
    <style>
        body { font-family: Arial; }
        .container { width: 600px; margin: auto; }
        label { display: block; margin: 5px 0; }
        input, select { width: 100%; padding: 8px; margin-bottom: 10px; }
        button { padding: 10px 15px; background: #28a745; border: none; color: #fff; }
        a { text-decoration: none; color: #007BFF; }
    </style>
</head>
<body>
<div class="container">
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
        <button type="submit">Upload and Preview</button>
    </form>
    <br>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
</div>
</body>
</html> 