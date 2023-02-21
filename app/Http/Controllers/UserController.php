<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Register a user
     * @param \illuminate\Http\Request
     * @return \illuminate\Http\Response 
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required | confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

       $token = $user->createToken($request->name)->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token
        ], 200);
    }

    /**
     * login user and assign token
     * @param \illuminate\Http\Request
     * @return \illuminate\Http\Response 
     * 
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where(['email' => $request->email])->firstOrFail();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'success' => false,
                'message' => 'The email or password not valid!'
            ], 401);
        }

        $token = $user->createToken($user->name)->plainTextToken;
        
        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token
        ], 200);
    }

    /**
     * logout user and delete the auth token
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully!'
        ], 200);
    }
}
