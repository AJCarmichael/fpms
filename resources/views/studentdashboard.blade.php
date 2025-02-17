@extends('layouts.app')

@section('content')
@if(Auth::user()->usertype == 'student')
<div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Notification Panel -->
        <div class="md:col-span-1 bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold mb-4">Notifications</h3>
            <nav class="space-y-2">
                <a href="{{ route('student.papers') }}" class="block p-2 hover:bg-gray-100 rounded">Papers</a>
                <a href="{{ route('student.internships') }}" class="block p-2 hover:bg-gray-100 rounded">Internship</a>
                <a href="{{ route('student.placements') }}" class="block p-2 hover:bg-gray-100 rounded">Placement</a>
                <a href="{{ route('student.notifications') }}" class="block p-2 hover:bg-gray-100 rounded">Notifications</a>
                <a href="{{ route('student.register') }}" class="block p-2 hover:bg-gray-100 rounded">Register</a>
                <a href="{{ route('student.higher-studies') }}" class="block p-2 hover:bg-gray-100 rounded">Higher Studies</a>
                <a href="{{ route('student.lor.index') }}" class="block p-2 hover:bg-gray-100 rounded">LOR</a>
                <a href="{{ route('student.profile') }}" class="block p-2 hover:bg-gray-100 rounded">My Account</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left p-2 hover:bg-gray-100 rounded">Logout</button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="md:col-span-3 space-y-4">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Name</p>
                        <p class="font-medium">{{ Auth::user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Roll Number</p>
                        <p class="font-medium">{{ $student->roll_number }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Department</p>
                        <p class="font-medium">{{ $student->department }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Year</p>
                        <p class="font-medium">{{ $student->year }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-4">Recent Activities</h3>
                <div class="space-y-4">
                    @foreach($notifications['general'] as $notification)
                        <div class="p-3 bg-gray-50 rounded">
                            <p class="text-sm">{{ $notification->message }}</p>
                            <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@else
    <p>You do not have permission to access this page.</p>
@endif
@endsection