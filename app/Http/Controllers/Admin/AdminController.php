<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // all users method 
    public function allUsers()
    {
        try {
            $post = User::all();
            Log::info("Users fetch successfully");
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Users fetch successfully',
                    'total' => $post->count(),
                    'data' => $post,
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Data not fetched',
            ], 404);
        }
    }

    // one user 
    public function singleUser($id)
    {
        try {
            $post = User::find($id);
            Log::info("Users fetch successfully");
            return response()->json(
                [
                    'status' => true,
                    'message' => 'User fetch successfully',
                    'data' => $post,
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'User not fetched',
            ], 404);
        }
    }


    // all tasks 
    public function allTask()
    {
        try {
            $allTasks = Task::all();
            Log::info("Tasks fetch successfully");
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Tasks fetch successfully',
                    'total' => $allTasks->count(),
                    'data' => $allTasks,
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Data not fetched',
            ], 404);
        }
    }
    //    single Task 
    public function oneTask($id)
    {
        try {
            $allTasks = Task::find($id);
            Log::info("Task fetch successfully");
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Task fetch successfully',
                    'data' => $allTasks,
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Task not fetched',
            ], 404);
        }
    }


    //    approve tasks 
    public function allRejectTask()
    {
        try {
            $RejectTasks = Task::where('status', 'rejected')->orderBy('created_at', 'DESC')->get();
            Log::info("Tasks fetch successfully");
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Reject task fetch successfully',
                    'total' => $RejectTasks->count(),
                    'data' => $RejectTasks,
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Data not fetched',
            ], 404);
        }
    }


    // rejected tasks 
    public function allApproveTask()
    {
        try {
            $ApproveTasks = Task::where('status', 'approved')->orderBy('created_at', 'DESC')->get();
            Log::info("Tasks fetch successfully");
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Approve task fetch successfully',
                    'total' => $ApproveTasks->count(),
                    'data' => $ApproveTasks,
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Data not fetched',
            ], 404);
        }
    }

    // pending tasks 
    public function allPendingTask()
    {
        try {
            $PendingTasks = Task::where('status', 'pending')->orderBy('created_at', 'DESC')->get();
            Log::info("Tasks fetch successfully");
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Pending task fetch successfully',
                    'total' => $PendingTasks->count(),
                    'data' => $PendingTasks,
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Data not fetched',
            ], 404);
        }
    }
    //  current loign user post 
    public function currentUserTask()
    {
        try {

            $user_id = Auth::id();
            $loginUserTask = Task::where('user_id', $user_id)->get();
            if (!$loginUserTask) {
                Log::warning("Task not found for user: $user_id");
                return response()->json([
                    'status' => false,
                    'message' => 'Task not found',
                    'totalUserTask' => $loginUserTask->count(),
                ], 404);
            }

            Log::info("Task fetched successfully for user: $user_id");

            return response()->json([
                'status' => true,
                'message' => 'User task fetched successfully',
                'data' => $loginUserTask,
            ], 200);
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Data not fetched',
            ], 500);
        }
    }

    // login user tasks pagination 
    public function adminLoginPagination()
    {
        try {
            //code...
            $user_id = Auth::id();
            $adminPagination = Task::where('user_id', $user_id)->limit(6)->orderBy('created_at', 'DESC')->get();
            Log::info("Task fetched successfully for user: $user_id");
            return response()->json([
                'status' => true,
                'message' => 'User task fetched successfully',
                'total_tasks' => $adminPagination->count(),
                'data' => $adminPagination,
            ], 200);
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Data not fetched',
            ], 500);
        }
    }


    // add admin tasks 
    public function addTask(Request $request)
    {
        $user_id = Auth::id();

        try {
            $request->validate([
                'task_name' => 'required|string',
                'description' => 'required|string',
            ]);

            $task = Task::create([
                'user_id' => Auth::id(),
                'task_name' => $request->task_name,
                'description' => $request->description,
                'status' => 'approved',
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
    //    admin profile 
    public function AdminProfile(Request $request)
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

    // delete post 
    public function deletePost($id)
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
}
