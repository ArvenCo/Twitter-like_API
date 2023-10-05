<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    //

    public function store(Request $request){

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|confirmed|min:8|max:16'
        ]);
        
        $user = User::create([
           'name' =>$fields['name'],
           'email' =>$fields['email'],
           'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('twitter-like')->plainTextToken();
        return response([
            'status' => 'created',
            'token' => $token,
            'user' => $user
        ], 201);
        

    }
}
