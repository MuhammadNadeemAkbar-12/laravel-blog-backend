<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
    public function deleteTask($id)
    {
        try {
            $task = Task::find($id);
            $task->delete();

            // for restore user post 
            // $task = Task::withTrashed()->find($id);
            // $task->restore();
            Log::info("Task Delete Successfully");
            return response()->json([
                'status' => true,
                'data' => $task,
            ], 200);
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Something Went Wrong'
            ], 500);
        }
    }
    // view user his task 
    public function userOwnTask($user_id)
    {
        try {
            $task = Task::where('user_id', $user_id)->get();
            Log::info("User Task Fectched Successfully");
            return response()->json([
                'status' => true,
                'message' => 'User Task Fectched Successfully',
                'data' => $task,

            ], 200);
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Something Went Wrong'
            ], 500);
        }
    }

    // edit user there task 
    public function editTask(Request $request, $id)
    {
        try {
            // Logged-in user ID
            $userId =  Auth::id();

            // Find the task belonging to the logged-in user
            $task = Task::where('id', $id)
                ->where('user_id', $userId)
                ->first();

            if (!$task) {
                return response()->json([
                    'status' => false,
                    'message' => 'Task not found or you are not authorized to edit it.',
                ], 404);
            }

            // Validate request
            $validatedData = $request->validate([
                'task_name' => 'required|string|max:255',
                'description' => 'required|string',
            ]);

            // Update task
            $task->update($validatedData);

            Log::info("Task updated successfully", ['task_id' => $task->id]);

            return response()->json([
                'status' => true,
                'message' => 'Task updated successfully',
                'data' => $task,
            ], 200);
        } catch (\Throwable $th) {
            Log::error("Something went wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }

    // user profile 
    public function userProfile($id)
    {
        try {
            $user_id = Auth::id();
            $profile = User::where('id', $id)
                       ->where('id', $user_id)
                       ->first();
            Log::info("User profile", ['user_id' => $profile->id]);
            return response()->json([
                'status' => true,
                'message' => 'Task updated successfully',
                'data' => $profile,
            ], 200);
        } catch (\Throwable $th) {
            Log::error("Something went wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }
}
