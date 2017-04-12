<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserForm;
use App\User;
use JWTAuth;

/**
 * This controller handles user management as creation or updates
 */
class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Create a new user
     *
     * @return object
     */  
    public function store(UserForm $request)
    {
        try {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password'))
            ]);

            return response()->json(['message' => 'User created successfully','data' => $user], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error was encountered', 'errors'=> $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get current User depending on header token authorization
     *
     * @return object
     */
    public function read()
    {
        $user = JWTAuth::toUser();
        return response()->json(['data' => $user]);
    }

    /**
     * Update current User depending on header token authorization
     *
     * @return object
     */
    public function update(UserForm $request)
    {
        try {
            $user = JWTAuth::toUser();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = bcrypt($request->get('password'));
            $user->save();

            return response()->json(['message' => 'User updated successfully','data' => $user]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error was encountered', 'errors'=> $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}