<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TweetController extends Controller
{
    //

    public function create(Request $request){
        $tweet = Tweet::create([
            'tweet' => $request['tweet'],
            'user_id' => $request->user()['id']
        ]);
        return response(['tweet'=> $tweet ], 201);
    }
}
