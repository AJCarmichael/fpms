<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlacementGroup;
use App\Models\PlacementDrive;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PlacementGroupController extends Controller
{
    public function index()
    {
        $groups = PlacementGroup::all();
        return view('placements.groups.index', compact('groups'));
    }
    
    public function create()
    {
        return view('placements.groups.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string',
            'thumbnail' => 'nullable|image'
        ]);
        
        $data = ['name' => $request->name];
        if ($request->hasFile('thumbnail')) {
            $filename = $request->file('thumbnail')->getClientOriginalName();
            $path = $request->file('thumbnail')->storeAs('thumbnails', $filename, 'public');
            $data['thumbnail'] = $path;
        }
        
        PlacementGroup::create($data);
        return redirect()->route('placementGroups.index')->with('success', 'Placement group created.');
    }

    public function edit($id)
    {
        $group = PlacementGroup::findOrFail($id);
        $allDrives = PlacementDrive::all();
        $groupDrives = $group->placementDrives->pluck('id')->toArray();
        return view('placements.groups.edit', compact('group', 'allDrives', 'groupDrives'));
    }

    public function update(Request $request, PlacementGroup $placementGroup)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'thumbnail' => 'nullable|image',
            'drives'    => 'nullable|array', // Expecting an array of drive IDs
        ]);

        $placementGroup->update($request->all());

        if ($request->has('drives')) {
            $driveIds = $request->drives;
            // Remove group assignment from drives not in the new list
            $placementGroup->placementDrives()->whereNotIn('id', $driveIds)
                ->update(['placement_group_id' => null]);
            // Assign this group to the selected drives
            \App\Models\PlacementDrive::whereIn('id', $driveIds)
                ->update(['placement_group_id' => $placementGroup->id]);
        }

        return redirect()->route('placementGroups.show', $placementGroup->id)
                         ->with('success', 'Placement group updated successfully.');
    }
    
    public function show(PlacementGroup $placementGroup)
    {
        // Load associated drives
        $placementGroup->load('placementDrives');
        return view('placements.groups.show', compact('placementGroup'));
    }

    public function destroy($id)
    {
        try {
            $group = PlacementGroup::findOrFail($id);
            $group->delete();
            return redirect()->route('placementGroups.index')->with('success', 'Placement group deleted.');
        } catch (Exception $e) {
            Log::error("Delete group error: " . $e->getMessage());
            return back()->withErrors(['Failed to delete placement group']);
        }
    }
}
