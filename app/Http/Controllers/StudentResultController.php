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
        // In a real-world system, these might come from configuration or the database
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
                $header = fgetcsv($handle, 1000, ",");
                while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                    $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }

            // Show preview with inline editing before committing the data
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
            $branch = $request->input('branch');
            $year = $request->input('year');
            $semester = $request->input('semester');

            foreach ($dataRows as $row) {
                // Extract CSV columns
                $rollNo   = $row['Roll Number'] ?? null;
                $name     = $row['Name'] ?? null;
                $seatNo   = $row['Seat No'] ?? null;
                $subject1 = $row['Subject1 CGPA'] ?? null;
                $subject2 = $row['Subject2 CGPA'] ?? null;
                $subject3 = $row['Subject3 CGPA'] ?? null;
                $subject4 = $row['Subject4 CGPA'] ?? null;
                $subject5 = $row['Subject5 CGPA'] ?? null;
                $subject6 = $row['Subject6 CGPA'] ?? null;
                $overall  = $row['Overall Semester CGPA'] ?? null;
                $sgpi     = $row['SGPI'] ?? null;
                $kt_flag  = isset($row['KT Flag']) && (strtolower($row['KT Flag']) == 'true' || $row['KT Flag'] == '1') ? true : false;

                if (!$rollNo) {
                    continue;
                }

                // Find (or create) the student record using roll number as unique identifier
                $student = Student::firstOrCreate(
                    ['roll_no' => $rollNo],
                    ['name' => $name, 'seat_no' => $seatNo, 'branch' => $branch, 'year' => $year, 'lifetime_kt_count' => 0]
                );

                // Update additional fields if needed
                $student->update([
                    'name'    => $name,
                    'seat_no' => $seatNo,
                    'branch'  => $branch,
                    'year'    => $year,
                ]);

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

                // Recalculate lifetime KT count by counting all result records with a KT flag
                $ktCount = $student->results()->where('kt_flag', true)->count();
                $student->lifetime_kt_count = $ktCount;
                $student->save();
            }

            return redirect()->route('dashboard')->with('success', 'Student results applied successfully.');
        } catch (Exception $e) {
            Log::error("Apply results error: " . $e->getMessage());
            return back()->withErrors(['Failed to apply student results.']);
        }
    }
}
