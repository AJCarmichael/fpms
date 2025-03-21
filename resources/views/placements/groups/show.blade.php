@extends('layouts.app')

@section('content')
<div class="card">
    <h2>{{ $placementGroup->name }}</h2>
    @if($placementGroup->thumbnail)
        <img src="{{ asset('storage/' . $placementGroup->thumbnail) }}" alt="{{ $placementGroup->name }} Thumbnail">
    @endif

    <h3>Drives in this Group</h3>
    @if($placementGroup->placementDrives->isEmpty())
        <p>No drives available.</p>
    @else
        <ul>
            @foreach($placementGroup->placementDrives as $drive)
                <li>
                    {{ $drive->company_name }} - {{ $drive->drive_date }}
                    <a href="{{ route('placements.show', $drive->id) }}" class="btn">View Drive</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
