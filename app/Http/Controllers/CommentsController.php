<?php

namespace App\Http\Controllers;
use App\Models\Comment;
// use Dom\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
   public function comments() {
    $comments = Comment::all();  
    return response()->json(
        [
            'status' => "success",
            'total' => $comments->count(),
            'data' => $comments,
        ]
    );  
   }    

//    one user comments 
   public function showUserComment($id){
    $showcomment = Comment::find($id);
    return response()->json([
        'status' => "success",
        'userComment' => $showcomment,
    ]); 
}
}
