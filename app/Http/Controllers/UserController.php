<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|unique:users',
                'password' => 'required|min:6',
                'privileges' => 'required',
            ]);

            User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'privileges' => $request->privileges,
            ]);

            return redirect()->route('dashboard')->with('success', 'User created successfully.');
        } catch (Exception $e) {
            Log::error("User creation error: " . $e->getMessage());
            return back()->withErrors(['Failed to create user.']);
        }
    }

    public function batchCreate(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file));

        foreach ($data as $row) {
            $rollNumber = $row[0];
            try {
                User::create([
                    'username' => $rollNumber,
                    'password' => Hash::make($rollNumber),
                    'privileges' => 'view-only',
                ]);
            } catch (Exception $e) {
                Log::error("Batch user creation error for roll number $rollNumber: " . $e->getMessage());
            }
        }

        return redirect()->route('dashboard')->with('success', 'Batch user creation completed.');
    }
}