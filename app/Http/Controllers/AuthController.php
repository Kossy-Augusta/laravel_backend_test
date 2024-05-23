<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Register a new user
    public function register(Request $request){
        $formFields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password'=> 'required|confirmed'
        ]);
        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);
        $response = ['user' => $user];

        return response($response, 201);
    }
    //Login a registered user
    public function login(Request $request){
        $formFields = $request->validate([
            'email' => 'required|string',
            'password'=> 'required|string'
        ]);
        $user = User::where('email', $formFields['email'])->first();
        // Check if password matches the stored password or email exists
        if (!$user || !Hash::check($formFields['password'], $user->password)){
            return response([
                'message' => 'Invalid Credentials'
            ], 401);
        }
        // generate token for the user and add 1 minute as expiration
        $token = $user->createToken('myApiToken', ['*'], now()->addWeek())->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

// Log out curreently authenticated user

    public function logout(Request $request){
        auth()->user()->tokens()->delete();


        return response([
            'message' => 'Logged out'
        ]);
    }
}
