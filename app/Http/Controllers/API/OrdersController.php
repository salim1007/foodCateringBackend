<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;



class OrdersController extends Controller
{
    public function placeOrder(Request $request)
    {
        Order::create([
            'user_id' => $request->user_id,
            'prod_list' => json_encode($request->prod_list),
            'total_amount' => $request->total_amount,
            'status' => 'Placed',
            'track_time' => Carbon::now(),
            'destination' => $request->location
        ]);

        return true;
    }

    public function getOrders(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $orders = $user->orders;
            foreach ($orders as $order) {
                $order->prod_list = json_decode($order->prod_list, true);
                $order->track_time = Carbon::parse($order->track_time)->format('H:i');
            }
        }
        return $orders;
    }
}
