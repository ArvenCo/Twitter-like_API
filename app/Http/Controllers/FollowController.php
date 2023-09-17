<?php

namespace App\Http\Controllers;


use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FollowController extends Controller
{
    //

    function exist($id){
        $user = User::find($id);
        $follow = Follow::where('user_id', Auth::id())->where('follow_user_id', $id);
        $user_exist = true;
        if ($user === null ){
            $user_exist = false;
        }
        $follow_exist = true;
        if (!$follow->exists()){
            $follow_exist = false;
        }
        
        return ['user' => $user_exist,'follow'=> $follow_exist,  $user];
    }

    public function store (Request $request){
        $fields = $request->validate([
            'follow_user_id' => 'required'
        ]);
        $exist = $this->exist($fields['follow_user_id']);
        if (!$exist['user']||$exist['follow']){
            return response(['status' => 'Bad Request', 'message' => 'User not exist or User already followed'], 400);
        }

        $follow = Follow::create([
            'user_id' => Auth::id(),
            'follow_user_id' => $fields['follow_user_id']
        ]);

        return response([
            'status' => 'success',
            'message' => 'User '.$exist[0]['name'].' followed',
            'followed' => $follow
        ],201);
    }

    public function destroy(int $follow_user_id){
        $exist = $this->exist($follow_user_id);

        if (!$exist['user'] ||!$exist['follow']){
            return response(['statu' => 'Bad Request', 'message' => 'User not found'], 400);
        }
       

        $follow = Follow::where('user_id', Auth::id())
        ->where('follow_user_id', $follow_user_id);
        $follow->delete();
        
        return response(['status' => 'Gone', 'message' => 'User '.$exist[0]['name'].' Unfollowed'], 410);
    }

    public function follow_list(){
        $follows = $follows = Follow::where('user_id', Auth::id())->get();
        return $follows;
    }


    public function suggest_follow(){
        $follows = $this->follow_list();
        $followed_ids = [];

        foreach ($follows as $follow){
            array_push($followed_ids, $follow->follow_user_id);
        }
       
        $users = User::whereNotIn('id', $followed_ids)->whereNot('id', Auth::id())->get()->random(10);
        return response([
            'suggest_users' => $users
        ], 200);
    }

    







    
}
