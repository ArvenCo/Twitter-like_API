<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UserFileController extends Controller
{


    //
    public function store(Request $request, $tweet_id= 'test'){
        $paths = [];

        foreach ($request->file('image') as $file){
            $path = $file->store('public/userfiles/tweet_attachment/'.$tweet_id.'/image');
            array_push($paths, $path);
        }
        foreach ($request->file('video') as $file){
            $path = $file->store('public/userfiles/tweet_attachment/'.$tweet_id.'/video');
            array_push($paths, $path);
        }
        if(count($paths) == 0){
            return false;
        }
        return true;
    }

    public function show($id){

        
        $paths = Storage::disk('public')->files('userfiles/tweet_attachment/'.$id.'/image');
        $paths = array_merge($paths, Storage::disk('public')->files('userfiles/tweet_attachment/'.$id.'/video'));

        $urls = [];
        foreach($paths as $path){
            array_push($urls, asset('storage/'.$path));
        }
        return $urls;
    }
}
