<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class TweetController extends Controller
{
    //

    public function store(Request $request)
    {
        $fields = $request->validate([
            'tweet' => 'present|nullable',
            'files' => 'present|nullable|max:50000000'
        ]);
        

        if (!$fields['tweet'] && !$fields['files'] ){
            return response([
                'status' => 'Bad Request',
                'message' =>'No Post'
            ], 400);
        }
        
        $tweet = Tweet::create([
            'tweet' => $fields['tweet'],
            'user_id' => $request->user()['id']
        ]);

        if( count($request->file('files')) > 0){
            $userFiles = new UserFileController;
            $response = $userFiles->store($request, $tweet->id);
            if(!$response){
                return response([
                    'message' => 'error'
                  ], 500);
            }
        }

        return response([ 'message' => 'Tweet posted', 'tweet'=> $tweet], 201);
    }

    public function update(Request $request, $tweet_id){
        $tweet = Tweet::find($tweet_id);
        $tweet->tweet = $request['tweet'];
        $tweet->save();
        return response(['message' => 'Tweet updated', 'tweet'=> $tweet], 201);
    }

    public function destroy($tweet_id){
        $tweet = Tweet::find($tweet_id);
        $tweet->delete();
        return response(['message' => 'Tweet deleted'], 201);
    }
}
