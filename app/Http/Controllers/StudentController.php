<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function dashboard()
    {
        try {
            $student = Auth::user()->student;
            $notifications = $this->getNotifications($student);
            $registrations = $student->registrations()->latest()->take(5)->get();
            $lorApplications = $student->lorApplications()->latest()->take(5)->get();

            return view('student.dashboard', compact('student', 'notifications', 'registrations', 'lorApplications'));
        } catch (Exception $e) {
            Log::error("Student dashboard error: " . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to load dashboard.']);
        }
    }

    private function getNotifications($student)
    {
        // Fetch notifications related to papers, internships, placements
        return [
            'papers' => [], // Implement paper notifications
            'internships' => [], // Implement internship notifications
            'placements' => [], // Implement placement notifications
            'general' => [] // Implement general notifications
        ];
    }

    public function profile()
    {
        try {
            $student = Auth::user()->student;
            return view('student.profile', compact('student'));
        } catch (Exception $e) {
            Log::error("Student profile error: " . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to load profile.']);
        }
    }
}