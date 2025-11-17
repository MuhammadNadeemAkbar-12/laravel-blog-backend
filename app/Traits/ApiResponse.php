<?php 
namespace App\Traits;

trait ApiResponse{
    public function success($data, $message, $status = 200){
        return response()->json([
            'status' => "SUCCESS",
            'message' => $message,
            'total' => is_countable($data) ? count($data) : null,
            'data' => $data
        ],$status);
    }


    public function error($data, $message, $status = 500){
        return response()->json([
            'status' => "ERROR",
            'message' => $message,
            'data' => $data,
        ],$status);
    }
}