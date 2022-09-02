<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $allUsers = count($users);
        if (count($users) === 0) {
            $response = response()->json(["status"=>404,"message" => 'No Search Results Found'],404);
        } else {
            $response = response()->json(["status"=>200,'data' => $users,'message' => 'Retrieved successfully',"Total Users"=>$allUsers],200);
        }
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateUser = [
            'fullname' =>   'required|string|min:5|max:50',
            'email' => 'required|string|email|max:60|unique:blog_users',
            'password' => 'required|min:8'
        ];
        $validator = Validator::make($request->all(),$validateUser);
        if ($validator->fails()) {
            $response =  response()->json(["status"=>422,"message" =>$validator->errors()],422);
        } else {
            $validateUser = new User;
            $validateUser->fullname = $request->fullname;
            $validateUser->email = $request->email;
            $validateUser->password = Hash::make($request->password);
            $result = $validateUser->save();
            // $token = $validateUser->createToken('auth_token')->plainTextToken;
            if ($result) {
                $response = response()->json(["status"=>200,"message" => 'User registration was successful'],200);
            } else {
                $response = response()->json(["status"=>400,"message" => 'Operation failed, User not registered'],400);
            }
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::find($id);
        if ($users) {
            $response = response()->json(["sucess"=>200, "user"=>$users,"message" => 'User Retrieved'],200);
        } else {
            $response = response()->json(["status"=>404,"message" => 'User does not exist'],404);
        }
        return $response;

    }

    public function search($name)
    {
        $name = User::where("fullname","like","%".$name."%")
        ->orWhere("email","like","%".$name."%")->get();
        $allUsers = count($name);
        if ($name) {
            $response = response()->json(["status"=>200,"user"=>$name, "Total Records"=>$allUsers,"message" => 'Users Retrieved successfully :)'],200);
        } else {
            $response = response()->json(["status"=>404,"message" => 'User does not exist'],404);
        }
        return $response;

    }

    // public function getFullUserInfo($name)
    // {
    //     $name = User::where("fullname","like","%".$name."%")
    //     ->orWhere("email","like","%".$name."%")->get();
    //     $allUsers = count($name);
    //     if ($name) {
    //         $response = response()->json(["status"=>200,"user"=>$name, "Total Records"=>$allUsers,"message" => 'Users Retrieved successfully :)'],200);
    //     } else {
    //         $response = response()->json(["status"=>404,"message" => 'User does not exist'],404);
    //     }
    //     return $response;

    // }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userUpdate = User::find($id);
        $userUpdate->fullname = $request->fullname;
        $saved = $userUpdate->save();
        if ($saved) {
            $response = response()->json(["status"=>200,"message" => 'Users updated successfully :)'],200);
        }else {
            $response = response()->json(["status"=>401,"message" => 'Failed to register a user'],401);
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                $user->delete();
                $response = response()->json(["status"=>200,"message" => 'Users Deleted successfully :)'],200);
            }else {
                $response =  response()->json(["status"=>404,"message" => 'Operation failed, User was not found'],404);
            }
            return $response;
        } catch (\Throwable $th) {
            report($th);
            return response()->json(["status"=>401,"message" => 'Operation failed, User not deleted'],401);
        }
    }
}
