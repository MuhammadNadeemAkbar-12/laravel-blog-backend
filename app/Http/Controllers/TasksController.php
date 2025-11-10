<?php


namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{ 
    public function task() {
        $post = Task::all();
        return response()->json(
            [
                'status' => "success",
                'total' => $post->count(),
                'data' => $post,
            ]
        );
    }
    
    // all approve task for home page
    public function allApproveTask() {
        $approve = Task::where('status', 'approved')->orderBy('created_at', 'desc')->limit(5)->get();
        return response()->json([
            'status' => 'success',
             'total_approveTask' => $approve->count(),
             'approveTask' => $approve,

        ]);
    } 
}
