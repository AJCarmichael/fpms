<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlacementGroup;
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
            $filename = $request->name . '.jpg';
            $path = $request->file('thumbnail')->storeAs('thumbnails', $filename, 'public');
            $data['thumbnail'] = $path;
        }
        
        PlacementGroup::create($data);
        return redirect()->route('placementGroups.index')->with('success', 'Placement group created.');
    }

    public function edit($id)
    {
        $group = PlacementGroup::findOrFail($id);
        return view('placements.groups.edit', compact('group'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string',
            'thumbnail' => 'nullable|image'
        ]);

        $group = PlacementGroup::findOrFail($id);
        $data = ['name' => $request->name];
        if ($request->hasFile('thumbnail')) {
            $filename = $request->name . '.jpg';
            $path = $request->file('thumbnail')->storeAs('thumbnails', $filename, 'public');
            $data['thumbnail'] = $path;
        }

        $group->update($data);
        return redirect()->route('placementGroups.index')->with('success', 'Placement group updated.');
    }
    
    public function destroy($id)
    {
        try {
            $group = PlacementGroup::findOrFail($id);
            // Optionally, delete related placement drives first or cascade delete.
            $group->delete();
            return redirect()->route('placementGroups.index')->with('success', 'Placement group deleted.');
        } catch (Exception $e) {
            Log::error("Delete group error: " . $e->getMessage());
            return back()->withErrors(['Failed to delete placement group.']);
        }
    }
}
