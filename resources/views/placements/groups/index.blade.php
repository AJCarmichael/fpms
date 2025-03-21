@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Placement Groups</h2>
    <a href="{{ route('placementGroups.create') }}" class="btn btn-primary mb-3">Create New Group</a>
    <ul class="list-group">
        @foreach($groups as $group)
            <li class="list-group-item">
                <h3>{{ $group->name }}</h3>
                @if($group->thumbnail)
                    <img src="{{ asset('storage/' . $group->thumbnail) }}" alt="{{ $group->name }}" class="img-thumbnail mb-3" style="width: 150px; height: auto;">
                @endif
                <p>Drives:</p>
                <ul class="list-group">
                    @foreach($group->placementDrives as $drive)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $drive->company_name }}
                            <form action="{{ route('placements.destroy', $drive->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-3">
                    <a href="{{ route('placementGroups.edit', $group->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('placementGroups.destroy', $group->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <a href="{{ route('placements.create', ['groupId' => $group->id]) }}" class="btn btn-success">Create Placement Drive</a>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
