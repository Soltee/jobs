<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use GuzzleHttp;
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
    	
    	
		return  reponse([
			'body' =>  json_encode($response->json()),
			'user' => $user,
		], 200);
	
    }


    /*register User*/
    public function register(Request $request)
    {
    	$data = $request->validate([
    		// 'is_employer'       => 'nullable|bool',
    		'name'      		=> 'required|string|min:2',
    		'email'     		=> 'required|string|email',
    		'password'  		=> 'required|string|min:8|confirmed'
    	]);

    	// $is_employer = ($data['is_employer']) ? true : false;

		User::create([
			// 'is_employer'       => $is_employer,
			'name'      		=> $data['name'],
			'email'     		=> $data['email'],
			'password'  		=> $data['password']
		]);

		return  response(['status' => 'Ok!'], 201);
    }

}
