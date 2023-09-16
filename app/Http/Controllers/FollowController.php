<?php

namespace App\Http\Controllers;


use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FollowController extends Controller
{
    //

    function user_exist($id){
        $user = User::find($id);
        $exist = true;
        if ($user === null){
            $exist = false;
        }
        return ['exist' => $exist, $user];
    }

    public function store (Request $request){
        $fields = $request->validate([
            'follow_user_id' => 'required'
        ]);
        
        $user = $this->user_exist($fields['follow_user_id']);

        if (!$user['exist']){
            return response(['status' => 'Bad Request'], 401);
        }

        $follow = Follow::create([
            'user_id' => Auth::id(),
            'follow_user_id' => $fields['follow_user_id']
        ]);

        return response([
            'status' => 'success',
            'message' => 'User '.$user[0]['name'].' followed',
            'followed' => $follow
        ],201);
    }

    public function destroy(int $follow_user_id){
        $user = $this->user_exist($follow_user_id);

        if (!$user['exist']){
            return response(['statu' => 'Bad Request'], 401);
        }

        $follow = Follow::where('user_id', Auth::id())
        ->where('follow_user_id', $follow_user_id);
        $follow->delete();
        
        return response(['status' => 'Gone', 'message' => 'User '.$user[0]['name'].' Unfollowed'], 410);
    }


    public function random_index(){
        $follows = Follow::select('follow_user_id')->where('user_id', Auth::id())->get();
        dd(21);
        $users = User::where('id', '!=', $follows['follow_user_id']);
        return response([
            'follows' => $follows, 'users' => $users['id']
        ], 200);
    }

    







    
}
