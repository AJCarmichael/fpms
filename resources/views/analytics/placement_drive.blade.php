<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Placement Drive Analytics</title>
    <!-- Include Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Analytics for Placement Drive: {{ $placementDrive->company_name }}</h1>
    <p>Drive Date: {{ $placementDrive->drive_date }} | Location: {{ $placementDrive->location }}</p>
    <a href="{{ route('placements.index') }}">Back to Placement Drives</a> <!-- added link -->
    
    <canvas id="placementChart" width="400" height="400"></canvas>
    
    <script>
        const ctx = document.getElementById('placementChart').getContext('2d');
        const data = {
            labels: ['Placed', 'Unplaced'],
            datasets: [{
                data: [{{ $placedCount }}, {{ $unplacedCount }}],
                backgroundColor: ['#4CAF50', '#F44336']
            }]
        };
        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true
            }
        };
        const placementChart = new Chart(ctx, config);
    </script>
</body>
</html>
