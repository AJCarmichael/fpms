<!DOCTYPE html>
<html>
<head>
    <title>Create Placement Drive</title>
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
    <h2>Create Placement Drive</h2>
    <form method="POST" action="{{ route('placements.store') }}">
        @csrf
        <label for="company_name">Company Name:</label>
        <input type="text" name="company_name" required>
        
        <label for="drive_date">Drive Date:</label>
        <input type="date" name="drive_date" required>
        
        <label for="location">Location:</label>
        <input type="text" name="location" required>
        
        <h3>Eligibility Criteria</h3>
        <label for="eligibility_branch">Branch:</label>
        <select name="eligibility_branch" required>
            @foreach($branches as $branch)
                <option value="{{ $branch }}">{{ $branch }}</option>
            @endforeach
        </select>
        
        <label for="eligibility_year">Year:</label>
        <select name="eligibility_year" required>
            @foreach($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
        
        <label for="kt_threshold">KT Threshold (maximum allowed KTs):</label>
        <input type="number" name="kt_threshold" required>
        
        <label for="min_cgpa">Minimum Overall Semester CGPA:</label>
        <input type="number" step="0.01" name="min_cgpa" required>
        
        <label for="min_sgpi">Minimum SGPI:</label>
        <input type="number" step="0.01" name="min_sgpi" required>
        
        <button type="submit">Create Drive</button>
    </form>
    <br>
    <a href="{{ route('placements.index') }}">Back to Placements</a>
</div>
</body>
</html> 