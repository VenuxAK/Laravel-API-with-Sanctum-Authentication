<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        // Validate request
        $request->validated($request->all());

        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone_no' => $request->phone_no ? $request->phone_no : null,
            'password' => $request->password,
        ]);

        // Response
        return response()->json([
            "message" => "User created successful",
            "status" => 201,
            "user" => $user,
            "api_token" => $user->createToken('API Token of ' . $user->name)->plainTextToken
        ]);
    }
    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!auth()->attempt($request->all())) {
            return response()->json([
                "message" => "Wrong credentials"
            ]);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            "message" => "Login Successful",
            "status" => 200,
            "user" => $user,
            "api_token" => $user->createToken('API Token of ' . $user->name)->plainTextToken
        ], 200);
    }
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => "Logout Successful",
            "status" => 200
        ]);
    }
}
