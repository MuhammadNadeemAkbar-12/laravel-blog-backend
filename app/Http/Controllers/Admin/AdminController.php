<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Traits\ApiResponse;

class AdminController extends Controller
{
    use ApiResponse; 

    // All Users Method
    public function allUsers()
    {
        try {
            $users = User::all();
            Log::info("Users fetched successfully");
            return $this->success($users, "Users fetched successfully");
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Data not fetched");
        }
    }

    // one user 
    public function singleUser($id)
    {
        try {
            $post = User::find($id);
            Log::info("Users fetch successfully");
            return $this->success($post, "User fecth success fully");
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Data not fetched");
        }
    }


    // all tasks 
    public function allTask()
    {
        try {
            $allTasks = Task::all();
            Log::info("Tasks fetch successfully");
            return $this->success($allTasks, "Tasks fetch successfully");
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Data not fetched");
        }
    }

    //    single Task 
    public function oneTask($id)
    {
        try {
            $allTasks = Task::find($id);
            Log::info("Task fetch successfully");
            return $this->success($allTasks, "Tasks fetch successfully");
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Data not fetched");
        }
    }


    //    rejected tasks 
    public function allRejectTask()
    {
        try {
            $RejectTasks = Task::where('status', 'rejected')->orderBy('created_at', 'DESC')->get();
            Log::info("Tasks fetch successfully");
            return $this->success($RejectTasks, "Tasks fetch successfully");
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Data not fetched");
        }
    }


    // approved tasks 
    public function allApproveTask()
    {
        try {
            $ApproveTasks = Task::where('status', 'approved')->orderBy('created_at', 'DESC')->get();
            Log::info("Tasks fetch successfully");
            return $this->success($ApproveTasks, "Tasks fetch successfully");
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Data not fetched");
        }
    }

    // pending tasks 
    public function allPendingTask()
    {
        try {
            $PendingTasks = Task::where('status', 'pending')->orderBy('created_at', 'DESC')->get();
            Log::info("Tasks fetch successfully");
            return $this->success($PendingTasks, "Tasks fetch successfully");
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Data not fetched");
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
                return $this->error(null, "Data not fetched");
               

            }

            Log::info("Task fetched successfully for user: $user_id");
            return $this->success($loginUserTask, "Tasks fetch successfully");
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Data not fetched");
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
            return $this->success($adminPagination, "Tasks fetch successfully");
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Data not fetched");
        }
    }


    // add admin tasks 
    public function addTask(Request $request)
    {

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
            Log::info("Task add Successfully");
            return $this->success($task, "Tasks add successfully");
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Data not fetched");
        }
    }

    //    admin profile 
    public function AdminProfile()
    {
        try {
            // $user_id = Auth::id();
            $profile = User::where('id', Auth::id())->first();
            Log::info("User profile", ['user_id' => $profile->id]);
            return $this->success($profile, "Profile fetch successfully");
        } catch (\Throwable $th) {
            Log::error("Something went wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Data not fetched");
        }
    }

    // delete post 
    public function deletePost($id)
    {
        try {
            $deleteTask = Task::find($id);
            if (!$deleteTask) {
                return $this->error(null, "On this id data not found fetched");
            }
            if ($deleteTask->user_id !== Auth::id()) {
                Log::warning("Unauthorized delete attempt", [
                    'task_id' => $id,
                    'task_owner' => $deleteTask->user_id,
                    'current_user' => Auth::id()
                ]);
                return $this->error(null, "Unauthorized: You can only delete your own tasks", 403);
            }
            $deleteTask->delete();
            Log::info("User profile", ['id' => $deleteTask->id]);
            return $this->success($deleteTask, "Task delete successfully");
        } catch (\Throwable $th) {
            Log::error("Something went wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Data not fetched");
        }
    }
}
