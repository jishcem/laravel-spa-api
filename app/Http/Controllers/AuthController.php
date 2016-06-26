<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class AuthController extends Controller
{
    public function postRegister(Requests\AuthRegisterRequest $request)
    {
        $user = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('passowrd'))
        ];
        $user = User::create($user);
        $token = \JWTAuth::fromUser($user);
        return response()->json(['token' => $token, 'user' => $user->toArray()]);
    }

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
        return $request->user()->toArray();
    }

    public function getMe(Request $request) {
        return $request->user()->toArray();
    }
}
