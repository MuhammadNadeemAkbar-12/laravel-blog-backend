<?php

namespace App\Http\Controllers\User; 

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function userNotification($id)
    {
        $user_id = Auth::id();
        try {
            

            $notification = Notification::where('id', $id)
                ->where('user_id', $user_id)->where('is_read', 1)->orderBy('created_at', 'desc')->first();
            if (!$notification) {
                return response()->json([
                    'status' => false,
                    'message' => 'Notification not found',
                ], 404);
            }
            
            Log::info("User notification fetched successfully", [
                'user_id' => $user_id,
                'notification_id' => $notification->id
            ]);
        
            return response()->json([
                'status' => true,
                'data' => $notification,
            ], 200);
            
        } catch (\Throwable $th) {
            Log::error("Notification fetch failed", [
                'message' => $th->getMessage(),
                'user_id' => Auth::id() ?? 'Guest'
            ]);
            
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }
}