@extends('layouts.app')

@section('content')
@if(Auth::user()->usertype == 'admin')
<?php
$totalStudents = \App\Models\Student::count();
$totalGroups = \App\Models\PlacementGroup::count();
$placedStudents = \App\Models\StudentResult::where('isPlaced', 'yes')->count();
?>

<div class="card">
    <h2>Welcome to the Placement Management Dashboard</h2>
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Total Students</h3>
            <p>{{ $totalStudents }}</p>
        </div>
        <div class="stat-card">
            <h3>Placement Groups</h3>
            <p>{{ $totalGroups }}</p>
        </div>
        <div class="stat-card">
            <h3>Placed Students</h3>
            <p>{{ $placedStudents }}</p>
        </div>
    </div>
</div>

<div class="card">
    <h3>Quick Actions</h3>
    <div class="quick-actions">
        <a href="{{ route('student_results.index') }}" class="btn">Manage Student Results</a>
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