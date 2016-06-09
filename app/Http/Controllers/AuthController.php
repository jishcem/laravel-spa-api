<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function postLogin(Request $request){
        $user = User::find(1);
        $token = JWTAuth::fromUser($user);
        return response()->json(['token' => $token, 'user' => $user]);
    }
}
