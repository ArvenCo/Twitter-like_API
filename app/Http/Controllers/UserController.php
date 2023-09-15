<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
class UserController extends Controller
{
    //

    public function suggest(){
        return response($user, 200);
    }
}
