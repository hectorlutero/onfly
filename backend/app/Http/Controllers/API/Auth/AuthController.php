<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\{AuthRequest, RegisterRequest};
use App\Mail\UserRegistered;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct(
        protected User $user,
        protected UserPolicy $userPolicy
    ) {
    }
    public function index(Request $request)
    {
        if (!Gate::check('view-any-user', auth()->user()))
            return response()->json(['message' => "You are not authorized to update this expense"], 403);


        $users = User::all()->toArray();
        return response()->json([
            'message' => 'All users',
            'users' => $users
        ]);
    }

    public function login(AuthRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user) return response()->json(['error' => 'User not found.'], 404);

        $hash = Hash::check($request->password, $user->password);

        if (!$hash) return response()->json(['error' => 'Invalid Credentials'], 401);


        $user->tokens()->delete();

        return response()->json([
            'token' => $user->createToken('authToken')->plainTextToken,
            'user' => $user
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

        Mail::to($user->email)->send(new UserRegistered($user));

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $user->createToken('authToken')->plainTextToken,
            'user' => $user,
        ], 201);
    }
}
