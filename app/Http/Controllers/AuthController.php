<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials are incorrect.',
                'errors' => null,
                'data' => null,
            ]);
        }
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully',
            'data' => [
                'token' => $token,
                'user' => $user,
            ]
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'data' => [
                'token' => $token,
                'user' => $user,
            ],
        ], 201);
    }
}
