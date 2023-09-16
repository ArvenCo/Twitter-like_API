<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserFileController extends Controller
{


    //
    public function store(Request $request, $tweet_id){
        $paths = [];
        foreach($request->file('files') as $file){
            $path = $file->store('public/userfiles/tweet_attachment/'.$tweet_id);
            array_push($paths, $path);
        }
        
        return true;
    }
}
