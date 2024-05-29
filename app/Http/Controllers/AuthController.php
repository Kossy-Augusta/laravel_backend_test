<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Register a new user
    public function register(RegisterRequest $request) : Response
    {
        $validatedData =$request->validated(); 
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        $response = ['user' => $user];

        return response($response, 201);
    }
    //Login a registered user
    public function login(LoginRequest $request){
        $validatedData= $request->validated();
        $credentials = $request->only('email', 'password');

        // Try to autheneticate user
        if(auth()->attempt($credentials)){
            // get instance of authenticated user
            $user = auth()->user();
            // generate token for the user and add one week as expiration
            $token = $user->createToken('myApiToken', ['*'], now()->addWeek())->plainTextToken;
    
            $products = Products::where('user_id', $user->id)->latest()->get();
            
    
            $response = [
                'user' => $user,
                'token' => $token,
                // 'products' => $products->isEmpty() ? 'No products for this user' : $products
            ];
    
            return response($response, 201);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

// Log out curreently authenticated user

     public function logout(Request $request){
        auth()->user()->tokens()->delete();


        return response([
            'message' => 'Logged out'
        ]);
    }
}