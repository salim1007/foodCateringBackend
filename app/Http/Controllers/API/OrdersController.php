<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;



class OrdersController extends Controller
{
    public function placeOrder(Request $request){
        Order::create([
            'user_id' => $request->user_id,
            'prod_list' => json_encode($request->prod_list),
            'total_amount' => $request->total_amount,
            'status'=> 'Placed',
            'destination' => $request->location
        ]);

        return true;

    }

    public function getOrders(Request $request){
        $orders = Order::where('user_id', $request->user_id)->get();
        
        foreach($orders as $order){
            $order->prod_list = json_decode($order->prod_list, true);
            
        }
        return $orders;
    }
}
