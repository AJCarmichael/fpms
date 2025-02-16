<?php

namespace App\Http\Controllers;

use App\Models\LorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;

class LorController extends Controller
{
    public function index()
    {
        try {
            $applications = Auth::user()->student->lorApplications;
            return view('student.lor.index', compact('applications'));
        } catch (Exception $e) {
            Log::error("LOR index error: " . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to load LOR applications.']);
        }
    }

    public function create()
    {
        return view('student.lor.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'professor_id' => 'required|exists:users,id',
                'purpose' => 'required|string',
                'university_name' => 'required|string',
                'course_name' => 'required|string'
            ]);

            $validated['student_id'] = Auth::user()->student->id;
            $validated['status'] = 'pending';
            $validated['submission_date'] = now();

            LorApplication::create($validated);

            return redirect()->route('student.lor.index')
                           ->with('success', 'LOR application submitted successfully.');
        } catch (Exception $e) {
            Log::error("LOR store error: " . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to submit LOR application.']);
        }
    }
}