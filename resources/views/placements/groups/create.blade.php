@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Create Placement Group</h2>
    <form method="POST" action="{{ route('placementGroups.store') }}" enctype="multipart/form-data">
        @csrf
        <label for="name">Group Name:</label>
        <input type="text" name="name" required>
        
        <label for="thumbnail">Thumbnail:</label>
        <input type="file" name="thumbnail">
        
        <button type="submit" class="btn">Create Group</button>
    </form>
    <br>
    <a href="{{ route('placementGroups.index') }}" class="btn">Back to Groups</a>
</div>
@endsection
