@extends('layouts.app')

@section('content')
    <h2>Change Password</h2>
    @if(session('error'))
        <p style="color:red;">{{ session('error') }}</p>
    @endif
    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif
    <form method="POST" action="{{ route('password.change.post') }}">
        @csrf
        <label>Current Password:</label><br>
        <input type="password" name="current_password" required><br><br>
        <label>New Password:</label><br>
        <input type="password" name="new_password" required><br><br>
        <label>Confirm New Password:</label><br>
        <input type="password" name="new_password_confirmation" required><br><br>
        <button type="submit">Change Password</button>
    </form>
    <br>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
@endsection
