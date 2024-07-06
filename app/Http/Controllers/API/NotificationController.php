<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        $notifications = Notification::where('user_id', $request->user_id)->where('status', 'not_viewed')->count();
        return $notifications;
    }

    public function updateNotifications(Request $request)
    {
        $notifications = Notification::where('user_id', $request->user_id)->where('status', 'not_viewed')->get();
        if($notifications){
           foreach ($notifications as $notification){
               $notification->status = 'viewed';
               $notification->save();
           }
           return $notifications->count();
        }
    }
}
