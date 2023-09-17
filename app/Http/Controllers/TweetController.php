<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\FollowController;

class TweetController extends Controller
{
    //

    public function store(Request $request)
    {
        $fields = $request->validate([
            'content' => 'present|nullable',
            'files' => 'present|nullable|max:50000000'
        ]);
        

        if (!$fields['content'] && !$fields['files'] ){
            return response([
                'status' => 'Bad Request',
                'message' =>'No Post'
            ], 400);
        }
        
        $tweet = Tweet::create([
            'content' => $fields['content'],
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
        $tweet->content = $request['content'];
        $tweet->save();
        return response(['message' => 'Tweet updated', 'tweet'=> $tweet], 201);
    }

    public function destroy($tweet_id){
        $tweet = Tweet::find($tweet_id);
        $tweet->delete();
        return response(['message' => 'Tweet deleted'], 201);
    }


    public function show_tweets($id = null){
        
        $follow_ids = [];
        $follows = new FollowController;
        
        foreach($follows->follow_list()as $follow){
            array_push($follow_ids, $follow['follow_user_id']);
        }

        if($id == null){
            $tweets = Tweet::whereIn('user_id', $follow_ids)->get();
        }else{
            if (!in_array($id, $follow_ids) && $id != Auth::id()){
                return response([
                  'status' => 'Bad Request',
                  'message' => 'You are not following this user'
                ], 400);
            }else{
                $tweets = Tweet::where('user_id', $id)->orderBy('created_at')->desc()->get();
            }
        }
       
       

        

        
        return response(['status'=> 'Success','tweets' => $tweets], 200);
        
        
    }
}
