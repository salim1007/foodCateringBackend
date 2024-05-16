<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $user = array();
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
            
        ]);

        $otp = rand(100000, 999999);

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'type' => 'user',
            'password' => Hash::make($request->password),
            'otp' => $otp
        ]);


        Mail::raw("Your new OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)->subject('Your new OTP for registration');
        });

        $userInfo = UserDetails::create([
            'user_id' => $user->id,
            'status' => 'active'
        ]);

      

        return $user;
    }

    public function getUser(){
        $user = array();

        $user = Auth::user();

        $user_details = $user->user_details;
        
        $categories =  Category::all();
        $user['categories'] = $categories;

        $main_course = Category::where('category_name', 'Main Course')->first();

        $default_product_group = Product::where('category_id', $main_course->id)->get();
        $user['main_course_products'] = $default_product_group;

        $all_products = Product::all();
        $user['products'] = $all_products;

        $user['user_details'] = $user_details;

        return $user;
    }

    public function getProds(){
        

        $categ = Category::where('category_name', 'Beverages')->first();
        $products = Product::where('category_id', $categ->id)->get();
        return $products;
        

    }

    public function login(Request $request){
        try {
          
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
    
            $user = User::where('email', $request->email)->first();
            
            if(!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect!']
                ]);
            }
    
            return $user->createToken($request->email)->plainTextToken;
        } catch (\Exception $e) {
            Log::error('Error during login: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
        
    }


    

    public function verifyOtp(Request $request){
        $user = User::where('email', $request->email)->first();

        if($user){
            if($user->otp == $request->otp){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }

    public function updateProfile(Request $request){
        $user = User::find($request->user_id);
        if($user){
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->user_details->address = $request->address;
            $user->save();
            $user->user_details->save();

        }
    }
}
