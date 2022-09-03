<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            } elseif (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                'message' => 'Invalid login details'
                        ], 401);
            } else{
                $user = User::where('email', $request['email'])->first();
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    "message" => 'Login successful',
                    "user"=>$user,
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ],200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }







    }

    public function userDetails(){
        $user = Auth::user();
        $post = $user->post;
        $allpost = count($post);
        return response()->json([
            'status' => true,
            "message" => 'This is '.$user->fullname. '\'s Information',
            "User Info"=>$user,
            "Total Post Created"=>$allpost
        ],200);
    }

    // public function logout()
    // {
    //     auth()->user()->tokens()->delete();

    //     return [
    //         'message' => 'Tokens Revoked'
    //     ];
    // }
}
