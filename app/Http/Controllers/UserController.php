<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|unique:users',
                'password' => 'required|min:6',
            ]);
            
            User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
            
            return redirect()->route('dashboard')->with('success', 'User created successfully.');
        } catch (Exception $e) {
            Log::error("User creation error: " . $e->getMessage());
            return back()->withErrors(['Failed to create user.']);
        }
    }
} 