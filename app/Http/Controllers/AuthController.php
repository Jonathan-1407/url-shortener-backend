<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthController extends Controller
{

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->avatar = 'default.png';
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->is_admin = 0;
            $user->state = 1;

            $user->save();

            return response()->json(['user' => $user, 'message' => 'User Created!'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 600
        ], 200);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'The credentials entered do not match our records'], 401);
        }

        if (!Auth::user()->state) {
            return response()->json(['message' => 'Account disabled'], 403);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get a authenticate user.
     *
     * @return Response
     */
    public function profile()
    {
        $user = Auth::user();
        return response()->json(["user" => $user], 200);
    }
}
