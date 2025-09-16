<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->hasRole('superadmin')) {
                $redirectUrl = route('admin.dashboard');
            } elseif ($user->hasRole('company')) {
                $redirectUrl = route('company.dashboard');
            } elseif ($user->hasRole('user')) {
                $redirectUrl = route('user.dashboard');
            } else {
                Auth::logout();
                return response()->json(['error' => 'No valid role'], 403);
            }

            return response()->json([
                'success' => true,
                'redirect_url' => $redirectUrl
            ]);
        }

        return response()->json([
            'messages' => ['email' => ['Invalid credentials']]
        ], 422);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Optional: invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::put('success', 'You have been logged out successfully.');
        return redirect()->route('login');
    }
}
