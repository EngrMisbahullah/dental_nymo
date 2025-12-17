<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ($user->is_locked) {
            throw ValidationException::withMessages([
                'email' => ['Account is locked. Please contact administrator.'],
            ]);
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Account is inactive. Please contact administrator.'],
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            $user->increment('failed_login_attempts');

            if ($user->failed_login_attempts >= 5) {
                $user->update(['is_locked' => true]);
            }

            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Reset failed attempts
        $user->update([
            'failed_login_attempts' => 0,
            'last_login_at' => now(),
        ]);

        // Create token
        $token = $user->createToken('auth-token')->plainTextToken;

        // Load relationships
        $user->load(['roles.permissions', 'practice']);

        // Log activity
        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'description' => 'User logged in',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'practice' => $user->practice,
                'roles' => $user->roles,
                'permissions' => $user->getPermissions(),
            ],
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'logout',
            'description' => 'User logged out',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load(['roles.permissions', 'practice']);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'practice' => $user->practice,
                'roles' => $user->roles,
                'permissions' => $user->getPermissions(),
            ],
        ]);
    }
}