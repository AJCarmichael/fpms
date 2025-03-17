<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentResult;

class AnalyticsController extends Controller
{
    public function getData()
    {
        $results = StudentResult::selectRaw('year, AVG(sgpi) as avg_sgpi')
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        $labels = $results->pluck('year');
        $avg_sgpi = $results->pluck('avg_sgpi');

        return response()->json([
            'labels' => $labels,
            'avg_sgpi' => $avg_sgpi,
        ]);
    }
}
