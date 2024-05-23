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
}
