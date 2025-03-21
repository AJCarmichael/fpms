@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Edit Placement Group</h2>
    <form method="POST" action="{{ route('placementGroups.update', $group->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="name">Group Name:</label>
        <input type="text" name="name" value="{{ $group->name }}" required>
        
        <label for="thumbnail">Thumbnail:</label>
        @if($group->thumbnail)
            <img src="{{ asset('storage/' . $group->thumbnail) }}" alt="{{ $group->name }}" class="img-thumbnail mb-3" style="width: 150px; height: auto;">
        @endif
        <input type="file" name="thumbnail">
        
        <h3>Placement Drives</h3>
        <ul class="list-group">
            @foreach($allDrives as $drive)
                <li class="list-group-item">
                    <input type="checkbox" name="drives[]" value="{{ $drive->id }}" {{ in_array($drive->id, $groupDrives) ? 'checked' : '' }}>
                    {{ $drive->company_name }} - {{ $drive->drive_date }}
                </li>
            @endforeach
        </ul>
        
        <button type="submit" class="btn">Update Group</button>
    </form>
    <br>
    <a href="{{ route('placementGroups.index') }}" class="btn">Back to Groups</a>
</div>
@endsection
