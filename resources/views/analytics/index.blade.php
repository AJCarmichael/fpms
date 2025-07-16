@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Analytics Dashboard</h1>
    <p class="text-center mb-4">View detailed analytics and export reports for placement groups.</p>

    <!-- Group selector -->
    <div class="row mb-5">
        <div class="col-md-6 offset-md-3">
            <label for="placementGroupSelect" class="form-label">Select Placement Group:</label>
            <div class="input-group">
                <select id="placementGroupSelect" class="form-control">
                    <option value="">-- Select Group --</option>
                    @foreach($placementGroups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
                <button id="confirmGroupButton" class="btn btn-primary">Confirm Group</button>
            </div>
        </div>
    </div>

    <!-- Analytics (hidden until confirmed) -->
    <div id="analyticsSection" style="display: none;">
        <div class="row mb-4">
            <div class="col-md-6">
                <h3 class="text-center">SGPI Distribution</h3>
                <canvas id="sgpiGraphCanvas"></canvas>
                <p class="text-center mt-2">This bar chart represents the SGPI distribution of students.</p>
            </div>
            <div class="col-md-6">
                <h3 class="text-center">Placement Status</h3>
                <canvas id="placementPieChartCanvas"></canvas>
                <p class="text-center mt-2">This pie chart shows the placement status of students.</p>
            </div>
        </div>

        <div class="text-center">
            <button id="exportPdfButton" class="btn btn-success">Export as PDF</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Hard‑coded data from testres.csv
    const sgpiData = [
        8.17, 7.93, 6.89, 8.29, 7.24, 8.95, 7.58, 8.79, 7.15, 8.38,
        7.93, 8.23, 6.88, 8.79, 7.21, 9.23, 7.13, 8.88, 6.63, 8.13,
        8.03, 8.33, 6.93, 9.03, 7.18, 9.38, 7.73, 8.39, 7.08, 8.68
    ];
    const placementStatus = { placed: 25, unplaced: 5 };

    let chartsInitialized = false,
        sgpiChart, placementChart;

    // 2. Get DOM nodes
    const btnConfirm = document.getElementById('confirmGroupButton'),
          section   = document.getElementById('analyticsSection'),
          sel       = document.getElementById('placementGroupSelect');

    // 3. Confirm group → show + init charts
    btnConfirm.addEventListener('click', function() {
        if (!sel.value) {
            return alert('Please select a placement group.');
        }
        section.style.display = 'block';

        if (!chartsInitialized) {
            // Bar chart
            const ctxBar = document.getElementById('sgpiGraphCanvas').getContext('2d');
            sgpiChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: sgpiData.map((_, i) => `Student ${i + 1}`),
                    datasets: [{
                        label: 'SGPI',
                        data: sgpiData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor:   'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Pie chart
            const ctxPie = document.getElementById('placementPieChartCanvas').getContext('2d');
            placementChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Placed', 'Unplaced'],
                    datasets: [{
                        data: [placementStatus.placed, placementStatus.unplaced],
                        backgroundColor: ['#4CAF50', '#F44336']
                    }]
                },
                options: { responsive: true }
            });

            chartsInitialized = true;
        } else {
            // If they re‑click, just resize
            sgpiChart.resize();
            placementChart.resize();
        }
    });

    // 4. Export to PDF
    document.getElementById('exportPdfButton').addEventListener('click', function() {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();
        pdf.text("Analytics Report", 105, 10, { align: "center" });
        pdf.text("SGPI Distribution", 10, 20);
        pdf.addImage(
            document.getElementById('sgpiGraphCanvas').toDataURL(),
            'PNG', 10, 25, 90, 60
        );
        pdf.text("Placement Status", 10, 95);
        pdf.addImage(
            document.getElementById('placementPieChartCanvas').toDataURL(),
            'PNG', 10, 100, 90, 60
        );
        pdf.save("analytics_report.pdf");
    });
});
</script>
@endsection
