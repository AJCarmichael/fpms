<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
    <style>
        body { font-family: Arial; }
        .container { width: 400px; margin: auto; }
        label { display: block; margin: 5px 0; }
        input { width: 100%; padding: 8px; margin-bottom: 10px; }
        button { padding: 10px 15px; background: #28a745; border: none; color: #fff; }
        a { text-decoration: none; color: #007BFF; }
    </style>
</head>
<body>
<div class="container">
    <h2>Create New User</h2>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Create User</button>
    </form>
    <br>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
</div>
</body>
</html> 