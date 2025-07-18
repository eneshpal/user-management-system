<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // Login: Authenticate user and return access token
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        // Create Passport access token
        $token = $user->createToken('auth_token')->accessToken;
        //dd($token);

        return response()->json([
            'access_token' => $token->token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }


    // Logout: Revoke the token
    public function logout(Request $request)
    {
        $user = $request->user();

        // Revoke the token that was used to authenticate the current request
        $user->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function register(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create user
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Optional: Assign default role
        $role = \App\Models\Role::where('name', 'User')->first();
        if ($role) {
            $user->roles()->attach($role->id);
        }

        // Create token
        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

}
