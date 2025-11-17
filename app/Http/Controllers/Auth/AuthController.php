<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Traits\ApiResponse;


use function Laravel\Prompts\error;

class AuthController extends Controller
{
    use ApiResponse;
    // for user register -------------------------------
    public function signup(StoreUserRequest $request)
    {
        try {


            $validated = $request->validated();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role_id' => $validated['role_id'] ?? 1,
            ]);
            return $this->success($user, "User register successfully", 200);
        } catch (\Exception $e) {
            Log::error("User Registration Failed", ['message' => $e->getMessage()]);
            return $this->error(null, "User Registration Failed", 500);
        }
    }

    // for login user ----------------------------------------
    public function login(Request $request)
    {
        try {
            // Auth attempt 
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $Authuser = Auth::user();
                return response()->json([
                    'status' => "Success",
                    'message' => "User login successfully",
                    'token' => $Authuser->createToken('auth_token')->plainTextToken,
                    'token_type' => 'bearer',
                ], 200);
            } else {
                return $this->error(null, "Invalid Email or Password", 401);
            }
        } catch (\Throwable $e) {
            //throw $th;
            Log::error("User Registration Failed", ['message' => $e->getMessage()]);
            return $this->error(null, "User Registration Failed", 500);
        }
    }

    // for logout ----------------------------------------------
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            Log::info("User Logout Successfully", ['user_id' => $request->user()->id]);
            return $this->success(null, "User logged out successfully");
        } catch (\Throwable $th) {
            Log::error('Error during logout', [
                'message' => $th->getMessage(),
            ]);

            return $this->error(null, "Some thing went worong", 500);
        }
    }
}
