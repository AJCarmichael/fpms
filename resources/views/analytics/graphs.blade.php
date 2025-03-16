@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Performance Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .chart-container {
            width: 50%;
            margin: auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <h1>Student Performance Statistics</h1>
    
    <div class="chart-container">
        <canvas id="cgpaBarChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="ktPieChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="avgCgpaLineChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="cgpaHistogram"></canvas>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            const response = await fetch("{{ route('fetch_csv_data') }}");
            const data = await response.json();
            
            const students = data.length;
            const cgpaAbove675 = data.filter(student => student.overall_semester_cgpa > 6.75).length;
            const cgpaAbove9 = data.filter(student => student.overall_semester_cgpa > 9.0).length;
            const studentsWithKT = data.filter(student => student.kt_flag === 1).length;
            const studentsWithoutKT = students - studentsWithKT;
            
            const semesterLabels = [...new Set(data.map(student => student.semester))].sort((a, b) => a - b);
            const avgCgpaPerSemester = semesterLabels.map(sem => {
                const semStudents = data.filter(student => student.semester == sem);
                return semStudents.reduce((sum, s) => sum + s.overall_semester_cgpa, 0) / semStudents.length;
            });
            
            const cgpaBins = ['5.0-5.5', '5.5-6.0', '6.0-6.5', '6.5-7.0', '7.0-7.5', '7.5+'];
            const cgpaDistribution = [
                data.filter(s => s.overall_semester_cgpa >= 5.0 && s.overall_semester_cgpa < 5.5).length,
                data.filter(s => s.overall_semester_cgpa >= 5.5 && s.overall_semester_cgpa < 6.0).length,
                data.filter(s => s.overall_semester_cgpa >= 6.0 && s.overall_semester_cgpa < 6.5).length,
                data.filter(s => s.overall_semester_cgpa >= 6.5 && s.overall_semester_cgpa < 7.0).length,
                data.filter(s => s.overall_semester_cgpa >= 7.0 && s.overall_semester_cgpa < 7.5).length,
                data.filter(s => s.overall_semester_cgpa >= 7.5).length
            ];

            // Bar Chart
            new Chart(document.getElementById("cgpaBarChart"), {
                type: 'bar',
                data: {
                    labels: ["CGPA > 6.75", "CGPA <= 6.75", "CGPA > 9.0"],
                    datasets: [{
                        label: "Number of Students",
                        data: [cgpaAbove675, students - cgpaAbove675 - cgpaAbove9, cgpaAbove9],
                        backgroundColor: ['green', 'red', 'blue']
                    }]
                }
            });

            // Pie Chart
            new Chart(document.getElementById("ktPieChart"), {
                type: 'pie',
                data: {
                    labels: ["With KT", "Without KT"],
                    datasets: [{
                        data: [studentsWithKT, studentsWithoutKT],
                        backgroundColor: ['red', 'blue']
                    }]
                }
            });

            // Line Chart
            new Chart(document.getElementById("avgCgpaLineChart"), {
                type: 'line',
                data: {
                    labels: semesterLabels,
                    datasets: [{
                        label: "Average CGPA",
                        data: avgCgpaPerSemester,
                        borderColor: "blue",
                        fill: false
                    }]
                }
            });

            // Histogram (Approximated as a bar chart)
            new Chart(document.getElementById("cgpaHistogram"), {
                type: 'bar',
                data: {
                    labels: cgpaBins,
                    datasets: [{
                        label: "Number of Students",
                        data: cgpaDistribution,
                        backgroundColor: "purple"
                    }]
                }
            });
        });
    </script>
</body>
</html>
@endsection
