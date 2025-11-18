<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Task;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{   
    use ApiResponse;

    // get all comments with tasks
    public function getallComments(){
        try {

            $comments = Task::with('comments')->get();
            Log::info("Comments fetched successfully");
            return $this->success($comments, "Comments  successfully");
            
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->error(null, "Something went wrong", 500);
        }
    }


    // sigle post comments 
    public function getCommentsByTaskId($id){
        try {
            // $comment = Comment::find($id);
            // return $comment->task->task_name;
            $task = Task::find($id);
            if (!$task) {
                Log::warning("Task not found", ['task_id' => $id]);
                return $this->error(null, "Task not found", 404);
            }
            $comments = $task->comments()->get();
            Log::info("Comments fetched successfully for task", ['task_id' => $id]);
            return $this->success($comments, "Comments fetched successfully");
            
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->error(null, "Something went wrong", 500);
        }
    }

  // get login user comments 
public function getUserComments()
{
    try {
        $user_id = Auth::id();

        if (!$user_id) {
            Log::warning("Unauthorized access attempt: No user logged in");
            return $this->error(null, "Unauthorized", 401);
        }

        $comments = Comment::where('user_id', $user_id)->get();

        Log::info("User comments fetched successfully", [
            'user_id' => $user_id,
            'total_comments' => $comments->count()
        ]);

        return $this->success($comments, "User comments fetched successfully");

    } catch (\Throwable $th) {
        Log::error("Error fetching user comments: ".$th->getMessage());
        return $this->error(null, "Something went wrong", 500);
    }
}
  


// add comment 
public function addComment(Request $request)
{
    // Validation
    $request->validate([
        'task_id' => 'required|exists:tasks,id',
        'comment_text' => 'required|string',
    ]);

    try {
        // Create comment
        $comment = Comment::create([
            'task_id' => $request->task_id,
            'comment' => $request->comment_text,
            'user_id' => Auth::id() ?? null,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Comment added successfully',
            'data'    => $comment
        ], 201);

    } catch (\Throwable $e) {

        return response()->json([
            'status'  => false,
            'message' => 'Failed to add comment',
            'error'   => $e->getMessage(),
        ], 500);
    }
}
// delete comment 

 public function deleteComment($id)
    {
        try {
            // Find the comment
            $comment = Comment::findOrFail($id);

            // Check if authenticated user owns the comment
            if ($comment->user_id !== Auth::id()) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized to delete this comment.'
                ], 403);
            }

            // Delete the comment
            $comment->delete();

            return response()->json([
                'status' => true,
                'message' => 'Comment deleted successfully.'
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete comment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

// Edit comment 
     public function updateComment(Request $request, $id)
    {
        // Validation
        $request->validate([
            'comment' => 'required|string',
        ]);

        try {
            // Find comment
            $comment = Comment::findOrFail($id);

            // Check ownership
            if ($comment->user_id !== Auth::id()) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized to edit this comment.'
                ], 403);
            }

            // Update comment
            $comment->comment_text = $request->comment;
            $comment->save();

            return response()->json([
                'status' => true,
                'message' => 'Comment updated successfully.',
                'data' => $comment
            ], 200);

        }  catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update comment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
