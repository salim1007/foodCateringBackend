<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProductToCart(Request $request){
        $request->validate([
            'user_id' => 'required',
            'prod_id' => 'required',
            'prod_qty' => 'required',
            'prod_image' => 'required',
            'total_price' => 'required',
        ]);

        if(Cart::where('user_id', $request->user_id)->where('prod_id', $request->prod_id)->exists()){
            return response()->json([
                'message' => 'Product already added to cart!',
                'status' => 409,
                'cartData' => null
            ],);

        }else{

            $cartData = Cart::create([
                'user_id' => $request->user_id,
                'prod_id' => $request->prod_id,
                'prod_qty' => $request->prod_qty,
                'prod_image' => $request->prod_image,
                'total_price' => $request->total_price,
                'prod_size' => $request->prod_size
            ]);


            return response()->json([
                'cartData' => $cartData,
                'status' => 201,
                'message' => 'Product Added to Cart!'
            ],);


        }

        
    }

    
}
