<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    public function register(Request $request)
    {
        $check_user = User::where('email', $request->email)->first();
        if ($check_user) {
            return response()->json([
                false,
                'message' => 'User with email already exists!'
            ]);
        } else {
            $user = array();

            $otp = rand(10000, 99999);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'type' => 'user',
                'password' => Hash::make($request->password),
                'otp' => $otp
            ]);

            UserDetails::create([
                'user_id' => $user->id,
                'status' => 'active'
            ]);

            Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
                $message->to($user->email)->subject('Your OTP for registration');
            });

            Notification::create([
                'user_id' => $user->id,
                'message' => json_encode([
                    'greeting' => "Hi $user->name, We're excited to have you join our food ordering community!",
                    'introduction' => "Our app is designed to bring your favorite meals from our restaurant right to your doorstep. With our user-friendly interface, you can explore a wide variety of food, customize your orders, and track them in real-time.",
                    'encouragement' => "Enjoy your gastronomic journey with us!",
                    'closing' => "Best Regards,",
                    'from' => "Ydde Fast Foods Ltd."
                ]),
                'status' => 'not_viewed'
            ]);


            return $user;
        }
    }


    public function signUpnWithGoogle(Request $request)
    {
        $user_email = User::where('email', $request->email)->first();

        if (!$user_email) {
            if ($request->name != 'no_user_name') {
                $user = User::create([
                    'email' => $request->email,
                    'type' => 'user',
                    'name' => $request->name,
                ]);
            } else {
                $user = User::create([
                    'email' => $request->email,
                    'type' => 'user',
                ]);
            }

            $userInfo = UserDetails::create([
                'user_id' => $user->id,
                'status' => 'active',
            ]);

            Notification::create([
                'user_id' => $user->id,
                'message' => json_encode([
                    'greeting' => "Hi there, We're excited to have you join our food ordering community!",
                    'introduction' => "Our app is designed to bring your favorite meals from our restaurant right to your doorstep. With our user-friendly interface, you can explore a wide variety of food, customize your orders, and track them in real-time.",
                    'encouragement' => "Enjoy your gastronomic journey with us!",
                    'closing' => "Best Regards,",
                    'from' => "Ydde Fast Foods Ltd."
                ]),
                'status' => 'not_viewed'
            ]);



            return $user->createToken($request->email)->plainTextToken;
        } else {
            return $user_email->createToken($request->email)->plainTextToken;
        }
    }

    public function getUser()
    {
        $user = array();

        $user = Auth::user();

        $user_details = $user->user_details;
        $user_notes = $user->user_notifications;
        $user['user_notes'] = $user_notes;

        $categories =  Category::all();
        $user['categories'] = $categories;

        $main_course = Category::where('category_name', 'Main Course')->first();

        $default_product_group = Product::where('category_id', $main_course->id)->get();

        foreach ($default_product_group as $product) {
            $average_rating = $product->ratings->avg('rating');
            $product['avg_product_rating'] = $average_rating;
        }

        $user['main_course_products'] = $default_product_group;

        $ads = Advertisement::all();
        $user['ads'] = $ads;


        $all_products = Product::all();
        $user['products'] = $all_products;





        $user['user_details'] = $user_details;



        return $user;
    }


    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'data_mismatch' => 'Incorrect credentials!',
                'status' => 401,
            ]);
        }

        return response()->json([
            'token' => $user->createToken($request->email)->plainTextToken,
            'status' => 200,
        ]);
    }


    public function verifyEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $otp = rand(10000, 99999);
            $user->update([
                'otp' => $otp,
            ]);

            Mail::raw("Your OTP for validation is: $otp", function ($message) use ($user) {
                $message->to($user->email)->subject('Validation OTP');
            });

            return response()->json([
                'new_otp' => $otp,
                'status' => 200,
            ]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    public function verifyOtp(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if ($user->otp == $request->otp) {
                return response()->json([
                    'user_token' => $user->createToken($request->email)->plainTextToken,
                ], 200);
            } else {
                return response()->json([
                    'otp_mismatch' => 'The OTP entered is invalid!'
                ], 200);
            }
        } else {
            return false;
        }
    }

    public function updateProfile(Request $request)
    {

        $user = User::find($request->user_id);
        if ($user) {
            $user->name = $request->username;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->user_details->address = $request->address;
            $user->save();
            $user->user_details->save();

            return $user;
        }
    }

    public function addNewPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
        }
    }

    public function removeUser(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->delete();
            return response()->json(true, 200);
        }
    }

    public function logout()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json(200);
    }
}
