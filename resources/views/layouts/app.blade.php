<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title', 'FCRIT Placement Management System')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
                <a href="{{ route('student_results.index') }}">Manage Student Results</a>
                <a href="{{ route('analytics.index') }}">Analytics</a>
                <a href="{{ route('users.create') }}">Create User</a>
                <a href="{{ route('placementGroups.index') }}">Manage Placement Groups</a>
                <a href="{{ route('password.change') }}">Change Password</a>
            @else
                <a href="{{ route('studentdashboard') }}">Dashboard</a>
                <a href="{{ route('student.profile') }}">My Account</a>
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

    <!-- global JS libs you need app‑wide -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    {{-- this is where each page’s @section('scripts') will be injected --}}
    @yield('scripts')
</body>
</html>
