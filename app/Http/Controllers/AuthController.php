<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class AuthController extends Controller
{
    public function postLogin(Request $request){
        if ( \Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')]) ) {
            $user = User::find(1);
            $token = \JWTAuth::fromUser($user);
            return response()->json(['token' => $token, 'user' => $user->toArray()]);
        } else {
            return response()->json([], 400);
        }
    }

    public function refreshToken (Request $request) {
        return $request->user();
    }

    public function getMe(Request $request) {
        return $request->user();
    }
}
