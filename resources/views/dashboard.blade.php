@extends('layouts.app')

@section('content')
@if(Auth::user()->usertype == 'admin')
<?php
$totalStudents = \App\Models\Student::count();
$totalDrives = \App\Models\PlacementDrive::count();
?>

<div class="card">
    <h2>Welcome to the Placement Management Dashboard</h2>
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Total Students</h3>
            <p>{{ $totalStudents }}</p>
        </div>
        <div class="stat-card">
            <h3>Placement Drives</h3>
            <p>{{ $totalDrives }}</p>
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
        <a href="{{ route('password.change') }}" class="btn">Change Password</a>
        <a href="{{ route('analytics.index') }}" class="btn">View Analytics</a>
    </div>
</div>
@else
    <p>You do not have permission to access this page.</p>
@endif
@endsection