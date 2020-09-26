<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Auth;
class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /*login User*/
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
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

    /**
     * Get the authenticated User.
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Refresh a token.
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**Logout */
    public function logout(){
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     * @param  string $token
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token'   => $token,
            'token_type'     => 'bearer',
            'expires_in'     => auth()->factory()->getTTL() * 60
        ]);
    }

}
