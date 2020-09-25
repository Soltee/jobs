<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Auth;
class AuthController extends Controller
{
    /*login User*/
    public function login(Request $request)
    {
    	$data = $request->validate([
    		'email'     => 'required|string|email',
    		'password'  => 'required|string|min:8'
    	]);

    	$user = User::where('email', $data['email'])->first();
    	if(Auth::attempt($data)){

    		return  reponse([
    			'token' =>  $user->createToken('unique-idntity&**()')->accessToken,
    			'user' => $user,
    		], 200);
        }
    	
	
    }


    /*register User*/
    public function register(Request $request)
    {
    	$data = $request->validate([
    		'is_employer'       => 'nullable|bool',
    		'name'      		=> 'required|string|min:2',
    		'email'     		=> 'required|string|email|unique:users',
    		'password'  		=> 'required|string|min:8|confirmed'
    	]);

    	$is_employer = ($data['is_employer']) ? true : false;

		$user = new User;
        $user->name        = $data['name'];
        $user->email       = $data['email'];
        $user->password    = bcrypt($data['password']);
        $user->is_employer = $data['is_employer'];
        $user->save();

        $token = $user->createToken('unique-idntity&**()')->accessToken;

		return  response([
                        'status' => 'Ok!',
                        'token'  =>  $token,
                        'user'   => $user
                    ], 201);
    }


    /**Logout */
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return Auth::logout();
    }

}
