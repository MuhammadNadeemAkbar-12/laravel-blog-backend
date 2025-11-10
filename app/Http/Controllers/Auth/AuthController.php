<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    // for user register 
    public function signup(Request $request)
    {
        $Validateuser = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',

            ]
        );
        if ($Validateuser->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Required all inputs",
                'errors' => $Validateuser->errors()->first(),

            ], 401);
        }
        // user create 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
           'password' => $request->password,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'User register succesfully',
            'data' => $user,
        ], 200);
    }

    // for login user 
    public function login()
    {
        $userValidate = Validator::make([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($userValidate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'User are un athenciate',
                'errors' => $userValidate->errors()->all(),
            ], 404);
        }
        // Auth attempt 
        if(Auth::attempt(['email' => $request->email, 'password', $request->password])){
            $Authuser = Auth::user();
            return response()->json([
                'status' => true,
                'message' => "User login successfully",
                'token' => $Authuser->createToken('auth_token')->plainTextToken,
                'tpekn_type' => 'bearer',

            ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Email password does not match',
                'errors' => $userValidate->errors()->all(),
            ], 404);
        }
    }

    // for logout 
    public function logout(Request $request) {
        $request->user();
        $request->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Logout succesfully',
        ]);

    }

}
