<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function users() {
        $user = User::all();
        return response()->json([
            'status' => "success",
            'total' => $user->count(),
            'data' => $user,
        ]);
    }

    // for one user 
    public function showuser($id){
        $showuser = User::findOrFail($id);
        return response()->json([
            'status' => "sucess",
            'user' => $showuser,
        ]);
    }

    // post new user 
    public function insert(Request $request) {
       $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
    
       ]);
       
       $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
       ]);

       return response()->json([
        'status' => "success",
        'data' => $user,
       ]);
       
    }

    

}