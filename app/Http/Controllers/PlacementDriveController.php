<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlacementDrive;
use App\Models\Student;
use App\Models\StudentResult;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\PlacementGroup; // if needed for listing groups

class PlacementDriveController extends Controller
{
    public function index()
    {
        $placements = PlacementDrive::all();
        return view('placements.index', compact('placements'));
    }

    public function create($group = null)
    {
        $branches = ['CSE', 'ECE', 'ME', 'CE'];
        $years = [1, 2, 3, 4];
        // Select only necessary fields including thumbnail so that group images can be shown
        $placementGroups = PlacementGroup::select('id', 'name', 'thumbnail')->get();
        return view('placements.create', compact('branches', 'years', 'placementGroups', 'group'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'company_name'        => 'required',
                'drive_date'          => 'required|date',
                'location'            => 'required',
                'eligibility_branch'  => 'required',
                'eligibility_year'    => 'required',
                'kt_threshold'        => 'required|integer',
                'min_cgpa'            => 'required|numeric',
                'min_sgpi'            => 'required|numeric',
                'placement_group_id'  => 'nullable|exists:placement_groups,id',
            ]);

            $placementDrive = PlacementDrive::create($request->all());

            // Filter students matching the criteria
            $eligibleStudents = Student::where('branch', $placementDrive->eligibility_branch)
                ->where('year', $placementDrive->eligibility_year)
                ->where('lifetime_kt_count', '<=', $placementDrive->kt_threshold)
                ->with(['latestResult' => function($query) {
                    $query->orderBy('semester', 'desc')
                          ->where('isPlaced', 'no');
                }])
                ->get()
                ->filter(function($student) use ($placementDrive) {
                    $result = $student->latestResult;
                    if (!$result) {
                        return false;
                    }
                    return $result->overall_semester_cgpa >= $placementDrive->min_cgpa &&
                           $result->sgpi >= $placementDrive->min_sgpi;
                });

            return view('placements.show', compact('placementDrive', 'eligibleStudents'))
                   ->with('success', 'Placement drive created successfully.');
        } catch (Exception $e) {
            Log::error("Create placement drive error: " . $e->getMessage());
            return back()->withErrors(['Failed to create placement drive.']);
        }
    }

    // New edit method for updating a placement drive
    public function edit(PlacementDrive $placementDrive)
    {
        $branches = ['CSE', 'ECE', 'ME', 'CE'];
        $years = [1, 2, 3, 4];
        // Retrieve groups with thumbnail for selection
        $placementGroups = PlacementGroup::select('id', 'name', 'thumbnail')->get();
        return view('placements.edit', compact('placementDrive', 'branches', 'years', 'placementGroups'));
    }

    // New update method for handling placement drive edits
    public function update(Request $request, PlacementDrive $placementDrive)
    {
        try {
            $request->validate([
                'company_name'        => 'required',
                'drive_date'          => 'required|date',
                'location'            => 'required',
                'eligibility_branch'  => 'required',
                'eligibility_year'    => 'required',
                'kt_threshold'        => 'required|integer',
                'min_cgpa'            => 'required|numeric',
                'min_sgpi'            => 'required|numeric',
                'placement_group_id'  => 'nullable|exists:placement_groups,id',
            ]);
            $placementDrive->update($request->all());
            return redirect()->route('placements.show', $placementDrive->id)
                             ->with('success', 'Placement drive updated successfully.');
        } catch (Exception $e) {
            Log::error("Update placement drive error: " . $e->getMessage());
            return back()->withErrors(['Failed to update placement drive.']);
        }
    }

    public function show(PlacementDrive $placementDrive)
    {
        try {
            // Filter students matching the criteria:
            // branch, year, lifetime KT count (≤ threshold) 
            // and (looking at their latest result) overall CGPA and SGPI
            $eligibleStudents = Student::where('branch', $placementDrive->eligibility_branch)
                ->where('year', $placementDrive->eligibility_year)
                ->where('lifetime_kt_count', '<=', $placementDrive->kt_threshold)
                ->with(['latestResult' => function($query) {
                    $query->orderBy('semester', 'desc')
                          ->where('isPlaced', 'no');
                }])
                ->get()
                ->filter(function($student) use ($placementDrive) {
                    $result = $student->latestResult;
                    if (!$result) {
                        return false;
                    }
                    return $result->overall_semester_cgpa >= $placementDrive->min_cgpa &&
                           $result->sgpi >= $placementDrive->min_sgpi;
                });

            return view('placements.show', compact('placementDrive', 'eligibleStudents'));
        } catch (Exception $e) {
            Log::error("Show placement drive error: " . $e->getMessage());
            return back()->withErrors(['Failed to load placement drive details.']);
        }
    }

    public function exportCsv(PlacementDrive $placementDrive)
    {
        try {
            // Use the same eligibleStudents logic as in show()
            $eligibleStudents = Student::where('branch', $placementDrive->eligibility_branch)
                ->where('year', $placementDrive->eligibility_year)
                ->where('lifetime_kt_count', '<=', $placementDrive->kt_threshold)
                ->with(['latestResult' => function($query) {
                    $query->orderBy('semester', 'desc')
                          ->where('isPlaced', 'no');
                }])
                ->get()
                ->filter(function($student) use ($placementDrive) {
                    $result = $student->latestResult;
                    if (!$result) {
                        return false;
                    }
                    return $result->overall_semester_cgpa >= $placementDrive->min_cgpa &&
                           $result->sgpi >= $placementDrive->min_sgpi;
                });

            $csvContent = "Roll Number,Name,Branch,Year,Current CGPA,Current SGPI,Lifetime KT Count\n";
            foreach ($eligibleStudents as $student) {
                $result = $student->latestResult;
                $csvContent .= "{$student->roll_no},{$student->name},{$student->branch},{$student->year},{$result->overall_semester_cgpa},{$result->sgpi},{$student->lifetime_kt_count}\n";
            }

            $filename = 'eligible_students_' . $placementDrive->id . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
            ];
            return Response::make($csvContent, 200, $headers)
                ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
        } catch (Exception $e) {
            Log::error("CSV export error: " . $e->getMessage());
            return back()->withErrors(['Failed to export CSV.']);
        }
    }

    public function createByResults(Request $request)
    {
        try {
            $request->validate([
                'company_name'        => 'required',
                'drive_date'          => 'required|date',
                'location'            => 'required',
                'eligibility_branch'  => 'required',
                'eligibility_year'    => 'required',
                'kt_threshold'        => 'required|integer',
                'min_cgpa'            => 'required|numeric',
                'min_sgpi'            => 'required|numeric',
            ]);

            $placementDrive = PlacementDrive::create($request->all());

            // Filter students matching the criteria
            $eligibleStudents = Student::where('branch', $placementDrive->eligibility_branch)
                ->where('year', $placementDrive->eligibility_year)
                ->where('lifetime_kt_count', '<=', $placementDrive->kt_threshold)
                ->with(['latestResult' => function($query) {
                    $query->orderBy('semester', 'desc')
                          ->where('isPlaced', 'no');
                }])
                ->get()
                ->filter(function($student) use ($placementDrive) {
                    $result = $student->latestResult;
                    if (!$result) {
                        return false;
                    }
                    return $result->overall_semester_cgpa >= $placementDrive->min_cgpa &&
                           $result->sgpi >= $placementDrive->min_sgpi;
                });

            return view('placements.show', compact('placementDrive', 'eligibleStudents'))
                   ->with('success', 'Placement drive created successfully.');
        } catch (Exception $e) {
            Log::error("Create placement drive by results error: " . $e->getMessage());
            return back()->withErrors(['Failed to create placement drive.']);
        }
    }

    // New method: Update placed students using a single-column CSV containing student IDs
    public function updatePlacedStudents(Request $request, PlacementDrive $placementDrive)
    {
        try {
            $request->validate(['csv_file' => 'required|file|mimes:csv,txt']);
            $file = $request->file('csv_file');
            $placedIds = [];
            if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
                while (($row = fgetcsv($handle, 0, ",")) !== false) {
                    if (isset($row[0]) && is_numeric($row[0])) {
                        $placedIds[] = trim($row[0]);
                    }
                }
                fclose($handle);
            }
            
            // Update the student_results for the corresponding student IDs to mark as placed ("yes")
            StudentResult::whereIn('student_id', $placedIds)
                ->where('isPlaced', 'no')
                ->update(['isPlaced' => 'yes']);
            
            return redirect()->route('placements.show', $placementDrive->id)
                             ->with('success', 'Placed student statuses updated.');
        } catch (Exception $e) {
            Log::error("Update placed students error: " . $e->getMessage());
            return back()->withErrors(['Failed to update placed students.']);
        }
    }

    public function destroy($id)
    {
        try {
            $placementDrive = PlacementDrive::findOrFail($id);
            $placementDrive->delete();
            return back()->with('success', 'Placement drive deleted successfully.');
        } catch (Exception $e) {
            Log::error("Delete placement drive error: " . $e->getMessage());
            return back()->withErrors(['Failed to delete placement drive.']);
        }
    }

    // New method to retrieve selection options for analytics
    public function selection()
    {
        // Retrieve all placement groups and individual drives
        $placementGroups = \App\Models\PlacementGroup::all();
        $placementDrives = PlacementDrive::all();
        // Return a view that lists available groups and drives for selection
        return view('placements.selection', compact('placementGroups', 'placementDrives'));
    }
}
