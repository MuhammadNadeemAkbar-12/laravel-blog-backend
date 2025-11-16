<?php 
namespace App\Traits;

trait ApiResponse{
    public function success($data, $message, $status = 200){
        return response()->json([
            'status' => true,
            'message' => $message,
            'total' => is_countable($data) ? count($data) : null,
            'data' => $data
        ],$status);
    }


    public function error($data, $message, $status = 404){
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ],$status);
    }
}