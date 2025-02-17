<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        try {
            // Validate credentials
            $credentials = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                
                // Check usertype and redirect accordingly
                $user = Auth::user();
                if ($user->usertype == 'admin') {
                    return redirect()->route('dashboard');
                } else {
                    return redirect()->route('studentdashboard');
                }
            }
            
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ]);
        } catch (Exception $e) {
            Log::error("Login error: " . $e->getMessage());
            return back()->withErrors(['An unexpected error occurred.']);
        }
    }
    
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        } catch (Exception $e) {
            Log::error("Logout error: " . $e->getMessage());
            return back()->withErrors(['An unexpected error occurred during logout.']);
        }
    }
}
