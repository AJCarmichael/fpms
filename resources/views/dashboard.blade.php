@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Welcome to the Placement Management Dashboard</h2>
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Total Students</h3>
            <p>{{ $totalStudents ?? 0 }}</p>
        </div>
        <div class="stat-card">
            <h3>Placement Drives</h3>
            <p>{{ $totalDrives ?? 0 }}</p>
        </div>
        <div class="stat-card">
            <h3>Placed Students</h3>
            <p>{{ $placedStudents ?? 0 }}</p>
        </div>
    </div>
</div>

<div class="card">
    <h3>Quick Actions</h3>
    <div class="quick-actions">
        <a href="{{ route('student_results.upload') }}" class="btn">Upload Results</a>
        <a href="{{ route('placements.create') }}" class="btn">Add Placement Drive</a>
        <a href="{{ route('users.create') }}" class="btn">Create User</a>
    </div>
</div>
@endsection 