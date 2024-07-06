<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class BookingController extends Controller
{
    public function bookTable(Request $request){
        Booking::create([
            'user_id' => $request->user_id,
            'date' =>$request->date,
            'time' => $request->time,
            'day' => $request->day,
            'no_of_people' => $request->no_of_people,
            'status' => 'upcoming'
        ]);

        return true;

    }

    public function getUserBookings(Request $request){
        try {
            $user = User::where('id', $request->user_id)->first();
            return $user->bookings;
        } catch (\Exception $e) {
            // Log the error message to the console
            Log::error($e->getMessage());
            // You can also return the error message to the caller
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function changeBookStatus(Request $request){
        $findBooking = Booking::find($request->book_id);
        if($findBooking){
            $findBooking->status = $request->status;
            $findBooking->save();
            return response()->json(['status' => 200]);
        }else{
            return false;
        }
    }
}
