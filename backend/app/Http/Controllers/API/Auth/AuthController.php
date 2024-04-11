<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\{AuthRequest, RegisterRequest};
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $hash = Hash::check($request->password, $user->password);

        if (!$user || !$hash) {
            return response()->json([
                'error' => 'Invalid Credentials'
            ], 401);
        }

        $user->tokens()->delete();

        return response()->json([
            'token' => $user->createToken('authToken')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }


    public function register(RegisterRequest $request)
    {
        $user = User::create($request->all());

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $user->createToken('authToken')->plainTextToken,
            'user' => $user,
        ]);
    }
}
