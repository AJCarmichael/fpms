@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Create User</h2>
    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="form-group">
            <label for="usertype">User Type:</label>
            <select name="usertype" id="usertype" required>
                <option value="admin">Admin</option>
                <option value="student">Student</option>
            </select>
        </div>
        <button type="submit" class="btn">Create User</button>
    </form>
</div>

<div class="card">
    <h2>Batch Create Users</h2>
    <form action="{{ route('users.batchCreate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="csv_file">Upload CSV File:</label>
            <input type="file" name="csv_file" id="csv_file" required>
        </div>
        <button type="submit" class="btn">Upload and Create Users</button>
    </form>
</div>
@endsection