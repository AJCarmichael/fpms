@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Placement Drives</h2>
    <div class="dashboard-stats">
        <a href="{{ route('placements.create') }}" class="btn">Create New Placement Drive</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Company</th>
                <th>Drive Date</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($placements as $placement)
                <tr>
                    <td>{{ $placement->id }}</td>
                    <td>{{ $placement->company_name }}</td>
                    <td>{{ $placement->drive_date }}</td>
                    <td>{{ $placement->location }}</td>
                    <td>
                        <a href="{{ route('placements.show', $placement->id) }}" class="btn btn-primary">View</a>
                        <form action="{{ route('placements.destroy', $placement->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>
</div>
@endsection