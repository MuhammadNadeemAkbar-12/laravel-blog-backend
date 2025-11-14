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
            $deleteTask = Task::find($id);
             if (!$deleteTask) {
                return response()->json([
                'status' => false,
                'message' => 'Task not found',
            ], 404);
        }
        if ($deleteTask->user_id !== Auth::id()) {
            Log::warning("Unauthorized delete attempt", [
                'task_id' => $id,
                'task_owner' => $deleteTask->user_id,
                'current_user' => Auth::id()
            ]);
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized: You can only delete your own tasks',
            ], 403);
        }


            $deleteTask->delete();
            Log::info("User profile", ['id' => $deleteTask->id]);
            return response()->json([
                'status' => true,
                'message' => 'Task Delete successfully',
                'data' => $deleteTask,
            ], 200);
        } catch (\Throwable $th) {
            Log::error("Something went wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }
    // view user his task 
    public function userOwnTask()
    {
        try {
            $user_id = Auth::id();
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

    // pagination limit 6 users 
    public function userOwnTaskPagination()
    {
        $user_id = Auth::id();
        try {
            $task = Task::where('user_id', $user_id)
                ->orderBy('created_at', 'DESC')
                ->limit(6)
                ->get();

            Log::info("User Task Fectched Successfully");
            return response()->json([
                'status' => true,
                'message' => 'User Task Fectched Successfully',
                'total_task' => $task->count(),
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

    // user profile 
    public function userProfile()
    {
        try {
            // $user_id = Auth::id();
            $profile = User::where('id', Auth::id())
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
