<!DOCTYPE html>
<html>
<head>
    <title>Placement Drives</title>
    <style>
        body { font-family: Arial; }
        .container { width: 800px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 8px; text-align: center; }
        a { text-decoration: none; color: #007BFF; }
        button { padding: 5px 10px; background: #28a745; border: none; color: #fff; }
    </style>
</head>
<body>
<div class="container">
    <h2>Placement Drives</h2>
    <a href="{{ route('placements.create') }}">Create New Placement Drive</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Company</th>
                <th>Drive Date</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($placements as $placement)
                <tr>
                    <td>{{ $placement->id }}</td>
                    <td>{{ $placement->company_name }}</td>
                    <td>{{ $placement->drive_date }}</td>
                    <td>{{ $placement->location }}</td>
                    <td>
                        <a href="{{ route('placements.show', $placement->id) }}">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
</div>
</body>
</html> 