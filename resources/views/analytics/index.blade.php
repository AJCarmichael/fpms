@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Analytics Dashboard</h1>
    <p>Welcome to the analytics dashboard. Here you can view various metrics and reports.</p>
    
    <!-- Dropdowns for selecting placement group and drive -->
    <div class="row mb-4">
        <div class="col-md-6">
            <label for="placementGroupSelect">Select Placement Group:</label>
            <select id="placementGroupSelect" class="form-control">
                <option value="">-- Select Group --</option>
                @foreach($placementGroups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="placementDriveSelect">Select Placement Drive:</label>
            <select id="placementDriveSelect" class="form-control">
                <option value="">-- Select Drive --</option>
                @foreach($placementDrives as $drive)
                    <option value="{{ $drive->id }}">{{ $drive->company_name }} ({{ $drive->drive_date }})</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h3>SGPI of the Batch</h3>
            <canvas id="sgpiGraphCanvas"></canvas>
        </div>
        <div class="col-md-6">
            <h3>Placement Status</h3>
            <canvas id="placementPieChartCanvas"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data from the database
    var results = @json($results);

    // Prepare data for the SGPI graph
    var labels = results.map(result => result.year);
    var data = results.map(result => result.avg_sgpi);

    var ctx = document.getElementById('sgpiGraphCanvas').getContext('2d');
    var sgpiGraphChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Average SGPI',
                data: data,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Data for the placement pie chart
    var ctxPie = document.getElementById('placementPieChartCanvas').getContext('2d');
    var placementPieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Placed', 'Unplaced'],
            datasets: [{
                data: [{{ $overallPlacedCount }}, {{ $overallUnplacedCount }}],
                backgroundColor: ['#4CAF50', '#F44336']
            }]
        },
        options: {
            responsive: true
        }
    });

    // Event listeners for dropdowns
    document.getElementById('placementGroupSelect').addEventListener('change', function() {
        var groupId = this.value;
        if (groupId) {
            window.location.href = '/analytics/placement-group/' + groupId;
        }
    });

    document.getElementById('placementDriveSelect').addEventListener('change', function() {
        var driveId = this.value;
        if (driveId) {
            window.location.href = '/analytics/placement-drive/' + driveId;
        }
    });
</script>
@endsection