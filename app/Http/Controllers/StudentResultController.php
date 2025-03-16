<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentResult;
use Illuminate\Support\Facades\Log;
use Exception;

class StudentResultController extends Controller
{
    public function showUploadForm()
    {
        $branches = ['CSE', 'ECE', 'ME', 'CE', 'IT'];
        $years = [1, 2, 3, 4];
        $semesters = [1, 2, 3, 4, 5, 6, 7, 8];
        return view('student_results.upload', compact('branches', 'years', 'semesters'));
    }

    public function processCSV(Request $request)
    {
        try {
            $request->validate([
                'csv_file' => 'required|file|mimes:csv,txt',
                'branch'   => 'required',
                'year'     => 'required',
                'semester' => 'required',
            ]);

            $branch = $request->branch;
            $year = $request->year;
            $semester = $request->semester;
            $file = $request->file('csv_file');
            $data = [];

            if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
                // Read header row and trim extra spaces
                if (($header = fgetcsv($handle, 0, ",")) !== false) {
                    $header = array_map('trim', $header);
                    while (($row = fgetcsv($handle, 0, ",")) !== false) {
                        // Only process rows with correct column count
                        if (count($row) === count($header)) {
                            $data[] = array_combine($header, $row);
                        }
                    }
                }
                fclose($handle);
            }

            // Show preview view so that user can edit data if needed
            return view('student_results.preview', compact('data', 'branch', 'year', 'semester'));
        } catch (Exception $e) {
            Log::error("CSV processing error: " . $e->getMessage());
            return back()->withErrors(['Failed to process CSV file.']);
        }
    }

    public function applyResults(Request $request)
    {
        try {
            $dataRows = $request->input('rows');
            $branch   = $request->input('branch');
            $year     = $request->input('year');
            $semester = $request->input('semester');

            foreach ($dataRows as $row) {
                // Extract CSV fields including name
                $rollNo   = $row['student_id'] ?? null;
                $name     = $row['name'] ?? null; // Make sure name is provided
                $subject1 = $row['subject1_cgpa'] ?? null;
                $subject2 = $row['subject2_cgpa'] ?? null;
                $subject3 = $row['subject3_cgpa'] ?? null;
                $subject4 = $row['subject4_cgpa'] ?? null;
                $subject5 = $row['subject5_cgpa'] ?? null;
                $subject6 = $row['subject6_cgpa'] ?? null;
                $overall  = $row['overall_semester_cgpa'] ?? null;
                $sgpi     = $row['sgpi'] ?? null;
                $kt_flag  = isset($row['kt_flag']) && (strtolower($row['kt_flag']) == 'true' || $row['kt_flag'] == '1');

                // Skip rows missing required fields
                if (!$rollNo || !$name) {
                    continue;
                }

                // Find or create student record with required fields
                $student = Student::firstOrCreate(
                    ['roll_no' => $rollNo],
                    ['name' => $name, 'branch' => $branch, 'year' => $year]
                );

                // Create the student result record for this semester
                StudentResult::create([
                    'student_id'            => $student->id,
                    'branch'                => $branch,
                    'year'                  => $year,
                    'semester'              => $semester,
                    'subject1_cgpa'         => $subject1,
                    'subject2_cgpa'         => $subject2,
                    'subject3_cgpa'         => $subject3,
                    'subject4_cgpa'         => $subject4,
                    'subject5_cgpa'         => $subject5,
                    'subject6_cgpa'         => $subject6,
                    'overall_semester_cgpa' => $overall,
                    'sgpi'                  => $sgpi,
                    'kt_flag'               => $kt_flag,
                ]);

                // Update lifetime KT count for the student
                $ktCount = $student->results()->where('kt_flag', true)->count();
                $student->lifetime_kt_count = $ktCount;
                $student->save();
            }

            return redirect()->route('dashboard')->with('success', 'Student results applied successfully.');
        } catch (Exception $e) {
            \Log::error("Apply results error: " . $e->getMessage());
            return redirect()->route('dashboard')->withErrors(['Failed to apply student results.']);
        }
    }

    public function viewResults()
    {
        $results = StudentResult::with('student')->get();
        return view('student_results.view', compact('results'));
    }
}
