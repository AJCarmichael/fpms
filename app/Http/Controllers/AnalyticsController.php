<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentResult;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Fetch data from the database
        $results = StudentResult::selectRaw('year, AVG(overall_semester_cgpa) as avg_cgpa')
            ->groupBy('year')
            ->get();

        // Pass data to the view
        return view('analytics.index', compact('results'));
    }
}
