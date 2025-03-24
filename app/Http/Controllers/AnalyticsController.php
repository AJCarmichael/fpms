<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentResult;
use App\Models\PlacementDrive;
use App\Models\PlacementGroup;
use App\Models\Student;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Fetch data from the database
        $results = StudentResult::selectRaw('year, AVG(sgpi) as avg_sgpi')
            ->groupBy('year')
            ->get();

        // New overall placement analytics data
        $overallPlacedCount = StudentResult::where('isPlaced', 'yes')->count();
        $overallUnplacedCount = StudentResult::where('isPlaced', 'no')->count();

        // Fetch placement groups and drives
        $placementGroups = PlacementGroup::all();
        $placementDrives = PlacementDrive::all();

        // Pass data to the view
        return view('analytics.index', compact('results', 'overallPlacedCount', 'overallUnplacedCount', 'placementGroups', 'placementDrives'));
    }

    public function placementGroupAnalytics($groupId)
    {
        // Fetch placement drives for the group
        $placementDrives = PlacementDrive::where('placement_group_id', $groupId)->get();

        // Fetch overall placement analytics for the group
        $overallPlacedCount = StudentResult::whereIn('placement_drive_id', $placementDrives->pluck('id'))->where('isPlaced', 'yes')->count();
        $overallUnplacedCount = StudentResult::whereIn('placement_drive_id', $placementDrives->pluck('id'))->where('isPlaced', 'no')->count();

        return view('analytics.placement_group', compact('placementDrives', 'overallPlacedCount', 'overallUnplacedCount'));
    }

    public function placementDriveAnalytics($driveId)
    {
        $placementDrive = PlacementDrive::findOrFail($driveId);

        // Fetch eligible students without filtering by placement status
        $students = Student::where('branch', $placementDrive->eligibility_branch)
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

        // Count placed and unplaced students
        $placedCount = $students->filter(function($student) {
            return isset($student->latestResult->isPlaced) && $student->latestResult->isPlaced === 'yes';
        })->count();
        $unplacedCount = $students->filter(function($student) {
            return !isset($student->latestResult->isPlaced) || $student->latestResult->isPlaced !== 'yes';
        })->count();

        return view('analytics.placement_drive', compact('placementDrive', 'placedCount', 'unplacedCount'));
    }
}
