<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;
class UserController extends Controller{

    use ApiResponse;

    // add new task 
    public function addNewTask(TaskUpdateRequest $request){
    try {
        $task = Task::create([
            'user_id' => Auth::id(), 
            'task_name' => $request->task_name,
            'description' => $request->description,
        ]);

        Log::info("Task Created Successfully", ['task_id' => $task->id]);
        return $this->success($task, "Task Created Successfully", 201);

    } catch (\Throwable $th) {
        Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
        return $this->error(null, "Task not added", 500);
    }
}
    // delete task 
    public function deleteTask($id)
    {
        try {
            $deleteTask = Task::find($id);
            if (!$deleteTask) {
                return $this->error(null, "Task not found");
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
            return $this->success($deleteTask, "Task Delete successfully");

        } catch (\Throwable $th) {
            Log::error("Something went wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Something went wrong");
        }
    }
    // view user his task 
    public function userOwnTask()
    {
        try {

            $task = Task::where('user_id', Auth::id())->get();
            Log::info("User Task Fectched Successfully");
            return $this->success($task, "Task Fectched Successfully");

        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "User Task Not Fectched");
        }
    }

    // edit user there task 
    public function editTask(Request $request, $id)
    {
        try {
            // Find the task belonging to the logged-in user
            $task = Task::where('id', $id)->where('user_id', Auth::id())->first();
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
            return $this->success($task, "Profile fetch successfully");
        } catch (\Throwable $th) {
            Log::error("Something went wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Something went wrong");
        }
    }

    // pagination limit 6 users 
    public function userOwnTaskPagination()
    {
        try {
            $task = Task::where('user_id', Auth::id())->orderBy('created_at', 'DESC')
                ->limit(6)
                ->get();

            Log::info("User Task Fectched Successfully");
            return $this->success($task, "Task Fectched Successfully");
        } catch (\Throwable $th) {
            Log::error("Something Went Wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Profile not fetched");
        }
    }

    // user profile 
    public function userProfile()
    {
        try {
            // $user_id = Auth::id();
            $profile = User::where('id', Auth::id())->first();
            Log::info("User profile", ['user_id' => $profile->id]);
            return $this->success($profile, "Profile fetch successfully");
        } catch (\Throwable $th) {
            Log::error("Something went wrong", ['message' => $th->getMessage()]);
            return $this->error(null, "Profile not fetched");
        }
    }
}
