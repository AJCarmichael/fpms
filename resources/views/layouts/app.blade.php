<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'FCRIT Placement Management System')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="header">
        <div class="header-content">
            <img src="{{ asset('images/fcritlogo.png') }}" class="logo" alt="FCRIT Logo">
            <h1>FCRIT Placement Management System</h1>
        </div>
        @auth
        <div class="nav">
            @if(Auth::user()->usertype == 'admin')
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('student_results.upload') }}">Manage Student Results</a>
                <a href="{{ route('placements.index') }}">Manage Placements</a>
                <a href="{{ route('users.create') }}">Create User</a>
                <a href="{{ route('password.change') }}">Change Password</a>
                {{--<a href="{{ route('admin.profile') }}">Admin Profile</a>--}}

            @elseif(Auth::user()->usertype == 'deptco')
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('student_results.upload') }}">Department Results</a>
                <a href="{{ route('placements.index') }}">Department Placements</a>
                <a href="{{ route('users.create') }}">Create Test</a>

                <a href="{{ route('password.change') }}">Change Password</a>
                <a href="{{ route('department.profile') }}">My Profile</a>

            @else
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('students.notifications') }}">Notifications</a>
                <a href="{{ route('students.test') }}">Placement Tests</a>
                <a href="{{ route('students.application') }}">Application</a>
                <a href="{{ route('password.change') }}">Change Password</a>
                {{--<a href="{{ route('student.profile') }}">My Account</a>--}}
            @endif
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
        @endauth
    </div>

    <div class="main-content">
        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert error">
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} FCRIT Placement Management System. All rights reserved.</p>
    </footer>
</body>
</html>