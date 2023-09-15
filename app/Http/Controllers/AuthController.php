<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    /**
     * Register new User
     */
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('twitter-like')->plainTextToken;

        return response ([
            'user' => $user,
            'token' => $token
        ], 201);
    }


    /**
     * Login
     */

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:8'
        ]);

        $user = User::where('email', $fields['email'])->first();
        
        if (!$user || !Hash::check($fields['password'],$user->password)){
            return response(['message'=>'Unauthorized'],401);
        }

        $token = $user->createToken('twitter-like')->plainTextToken;

        return response ([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    /**
     * logout and delete user tokens
     */
    public function logout(){
        auth()->user()->tokens()->delete();
        return response(['message' =>'User logged out'],200);
    }
}
