<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlacementDrive;
use App\Models\Student;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class PlacementDriveController extends Controller
{
    public function index()
    {
        $placements = PlacementDrive::all();
        return view('placements.index', compact('placements'));
    }

    public function create()
    {
        $branches = ['CSE', 'ECE', 'ME', 'CE'];
        $years = [1, 2, 3, 4];
        return view('placements.create', compact('branches', 'years'));
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
            ]);

            $placementDrive = PlacementDrive::create($request->all());

            // Filter students matching the criteria
            $eligibleStudents = Student::where('branch', $placementDrive->eligibility_branch)
                ->where('year', $placementDrive->eligibility_year)
                ->where('lifetime_kt_count', '<=', $placementDrive->kt_threshold)
                ->with(['latestResult' => function($query) {
                    $query->orderBy('semester', 'desc');
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
                    $query->orderBy('semester', 'desc');
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
                    $query->orderBy('semester', 'desc');
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
                    $query->orderBy('semester', 'desc');
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
}
