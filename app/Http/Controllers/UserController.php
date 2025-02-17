<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Render the user creation view
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
                'usertype' => 'required|in:admin,student',
            ]);

            User::create([
                'name'     => 'default name',
                'username' => $request->username,
                'email'    => $request->username . '@example.com',
                'password' => Hash::make($request->password),
                'usertype' => $request->usertype,
            ]);

            return redirect()->route('dashboard')->with('success', 'User created successfully.');
        } catch (Exception $e) {
            Log::error("User creation error: " . $e->getMessage());
            return back()->withErrors(['Failed to create user: ' . $e->getMessage()]);
        }
    }

    // New batch creation method for CSV upload
    public function batchCreate(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        while (($data = fgetcsv($handle)) !== false) {
            $roll = trim($data[0]);
            if (!empty($roll)) {
                try {
                    User::create([
                        'name'     => 'default name',
                        'username' => $roll,
                        'email'    => $roll . '@example.com',
                        'password' => Hash::make($roll),
                    ]);
                } catch(Exception $ex) {
                    Log::error("Batch user creation error for roll {$roll}: " . $ex->getMessage());
                    // Continue processing remaining rows
                }
            }
        }
        fclose($handle);

        return redirect()->route('dashboard')->with('success', 'Batch user creation completed.');
    }
}