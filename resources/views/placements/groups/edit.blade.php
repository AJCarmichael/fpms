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
        <input type="file" name="thumbnail">
        
        <button type="submit" class="btn">Update Group</button>
    </form>
    <br>
    <a href="{{ route('placementGroups.index') }}" class="btn">Back to Groups</a>
</div>
@endsection
