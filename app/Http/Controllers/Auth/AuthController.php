<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    // for user register -------------------------------
    public function signup(Request $request)
    {
        $Validateuser = Validator::make(
            $request->all(),
            [
                'name' => 'required||string|min:3|max:50|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required||string|max:255|email|unique:users,email',
                'password' => 'required|max:255|confirmed',

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
            'password' => bcrypt($request->password),
        ]);
        return response()->json([
            'status' => true,
            'message' => 'User register succesfully',
            'data' => $user,
        ], 200);
    }

    // for login user ----------------------------------------
    public function login(Request $request)
    {
        try {
             $userValidate = Validator::make(
            $request->all(),
            [
                'email' => 'required|string|max:255|email',
                'password' => 'required|max:255',
            ]
        );

         // Auth attempt 
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $Authuser = Auth::user();
            return response()->json([
                'status' => true,
                'message' => "User login successfully",
                'token' => $Authuser->createToken('auth_token')->plainTextToken,
                'token_type' => 'bearer',
            ], 200);
        }else {
            return response()->json([
                'status' => false,
                'message' => "Invalid Password",
            ], 401);
        }

        } catch (\Throwable $th) {
            //throw $th;
             if ($userValidate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'User are un athenciate',
                'errors' => $userValidate->errors()->all(),
            ], 404);
        }

             return response()->json([
                'status' => false,
                'message' => 'Email password does not match',
                'errors' => $userValidate->errors()->all(),
            ], 404);
        }
    }

    // for logout ----------------------------------------------
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            Log::info("User Logout Successfully", ['user_id' => $request->user()->id]);
            return response()->json([
                'status' => true,
                'message' => 'Logout successfully',
            ], 200);

            
        } catch (\Throwable $th) {
            Log::error('Error during logout', [
            'message' => $th->getMessage(),
        ]);
            return response()->json([
                'status' => false,
                'message' => "Some thing went worong", 

            ],500);
        }
    }
}
