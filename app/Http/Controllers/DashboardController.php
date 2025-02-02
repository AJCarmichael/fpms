<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            return view('dashboard');
        } catch (Exception $e) {
            Log::error("Dashboard index error: " . $e->getMessage());
            return redirect()->route('login')->withErrors(['Unable to load dashboard.']);
        }
    }
} 