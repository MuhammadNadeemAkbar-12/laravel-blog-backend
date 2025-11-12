<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function users()
    {
        $user = User::all();
        return response()->json([
            'status' => "success",
            'total' => $user->count(),
            'data' => $user,
        ]);
    }

    // for one user 
    public function showuser($id)
    {
        $showuser = User::findOrFail($id);
        return response()->json([
            'status' => "sucess",
            'user' => $showuser,
        ]);
    }

    // add new task 
    public function addnewTask(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'task_name' => 'required|string',
                'description' => 'required|string',
            ]);

            $task = Task::create([
                'user_id' => $request->user_id,
                'task_name' => $request->task_name,
                'description' => $request->description,
            ]);
            Log::info("User Logout Successfully");
            return response()->json([
                'status' => true,
                'data' => $task,
            ], 201);
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Something Went Wrong'
            ], 500);
        }
    }

    // delete task 
    public function deleteTask() {
        try {
            
        } catch (\Throwable $th) {
           
        }
    }
}
