<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use JWTAuthException;

/**
 *This controller handles authenticating users for the application.    
 */
class LoginController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => 'login']);
    }

    /**
     * Create a new JWTAuth user login
     *
     * @return object, header authorization
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $token = null;
        
        try {
           if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Validation Failed', 'errors'=> 'Invalid email or password'], Response::HTTP_UNPROCESSABLE_ENTITY);
           }
        } catch (JWTAuthException $e) {
            return response()->json(['message' => 'An error was encountered', 'errors'=> $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        return response()->json(['data' => JWTAuth::toUser($token)])->header('Authorization', 'Bearer ' . $token);
    }

    /**
     * Logout for JWTAuth User
     *
     * @return object
     */
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Logout successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error was encountered', 'errors'=> $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}