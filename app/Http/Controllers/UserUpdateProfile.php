<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserUpdateProfile extends Controller
{


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $userUpdate = User::find($id);
        try {
            $user = Auth::user();
            $validateUser = Validator::make($request->all(),
                [
                    'fullname' => 'required|string|min:5|max:50',
                ]);
                if($validateUser->fails()){
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateUser->errors()
                    ], 422);
                }
                else {
                    if ($user->id == $id) {
                        $user->fullname = $request->fullname;
                        $saved = $user->update();
                        if ($saved) {
                            $response = response()->json(["status" => true, "message" => 'Users updated successfully :)'], 200);
                        } else {
                            $response = response()->json(["status" => false, "message" => 'Failed to update a user'], 401);
                        }

                    } else {
                        $response = response()->json(["status" => false, "message" => 'Failed to update, this id does not belong to you'], 403);
                    }
                }
        } catch (\Throwable $th) {
            $response = response()->json([
                "status"=>false,
                "message" => 'Operation failed'.$th
            ],400);
        }
        return $response;

    }


}
