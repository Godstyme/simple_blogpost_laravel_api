<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
            'message' => 'Invalid login details'
                    ], 401);
                }

            $user = User::where('email', $request['email'])->first();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                    "message" => 'Login successful',
                    "user"=>$user,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
            ],200);
        }
}
