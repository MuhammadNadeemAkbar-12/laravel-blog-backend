<?php

namespace App\Http\Controllers\User; 

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    use ApiResponse;
    public function userNotification()
    {
        $user_id = Auth::id();
        try {
            $notification = Notification::where('user_id', $user_id)->where('is_read', 1)->orderBy('created_at', 'desc')->first();
            if (!$notification) {
                 return $this->error(null, "Notification not found");
            }
            
            Log::info("User notification fetched successfully", [
                'user_id' => $user_id,
                'notification_id' => $notification->id
            ]);
        
           return $this->success($notification, "User notification fetched successfully");
            
        } catch (\Throwable $th) {
            Log::error("Notification fetch failed", [
                'message' => $th->getMessage(),
                'user_id' => Auth::id() ?? 'Guest'
            ]);
            
            return $this->error(null, "Something went wrong");
        }
    }
}