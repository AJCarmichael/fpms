@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Analytics Dashboard</h1>
    <p>Welcome to the analytics dashboard. Here you can view various metrics and reports.</p>
    
    <div class="row">
        <div class="col-md-6">
            <h3>Graph</h3>
            <canvas id="graphCanvas"></canvas>
        </div>
        <div class="col-md-6">
            <h3>Pie Chart</h3>
            <canvas id="pieChartCanvas"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dummy data for the graph
    var ctx = document.getElementById('graphCanvas').getContext('2d');
    var graphChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Dummy Data',
                data: [65, 59, 80, 81, 56, 55, 40],
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

    // Dummy data for the pie chart
    var ctxPie = document.getElementById('pieChartCanvas').getContext('2d');
    var pieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Red', 'Blue', 'Yellow'],
            datasets: [{
                label: 'Dummy Data',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
@endsection