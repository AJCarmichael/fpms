<!DOCTYPE html>
<html>
<head>
    <title>Placement Drive Details</title>
    <style>
        body { font-family: Arial; }
        .container { width: 800px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 8px; text-align: center; }
        a { text-decoration: none; color: #007BFF; }
        button { padding: 5px 10px; background: #007BFF; border: none; color: #fff; }
    </style>
</head>
<body>
<div class="container">
    <h2>Placement Drive: {{ $placementDrive->company_name }}</h2>
    <p>Date: {{ $placementDrive->drive_date }}</p>
    <p>Location: {{ $placementDrive->location }}</p>
    <h3>Eligibility Criteria</h3>
    <ul>
        <li>Branch: {{ $placementDrive->eligibility_branch }}</li>
        <li>Year: {{ $placementDrive->eligibility_year }}</li>
        <li>KT Threshold: {{ $placementDrive->kt_threshold }}</li>
        <li>Minimum Overall CGPA: {{ $placementDrive->min_cgpa }}</li>
        <li>Minimum SGPI: {{ $placementDrive->min_sgpi }}</li>
    </ul>
    <h3>Eligible Students</h3>
    <a href="{{ route('placements.export', $placementDrive->id) }}">Export Eligible Students as CSV</a>
    <table>
        <thead>
            <tr>
                <th>Roll Number</th>
                <th>Name</th>
                <th>Branch</th>
                <th>Year</th>
                <th>Current CGPA</th>
                <th>Current SGPI</th>
                <th>Lifetime KT Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eligibleStudents as $student)
                <tr>
                    <td>{{ $student->roll_no }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->branch }}</td>
                    <td>{{ $student->year }}</td>
                    <td>{{ $student->latestResult->overall_semester_cgpa }}</td>
                    <td>{{ $student->latestResult->sgpi }}</td>
                    <td>{{ $student->lifetime_kt_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <a href="{{ route('placements.index') }}">Back to Placements</a>
</div>
</body>
</html> 