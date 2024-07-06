<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getCarts(Request $request)
    {
        $cartItems = Cart::where('user_id', $request->user_id)->get();

        foreach ($cartItems as $cartItem) {
            $productName = Product::where('id', $cartItem->prod_id)->value('product_name');

            $cartItem['product_name'] = $productName;
        }

        return $cartItems;
    }

    public function cartIncr(Request $request)
    {
        $cartProduct = Cart::where('user_id', $request->user_id)->where('prod_id', $request->prod_id)->first();
        $divider = $cartProduct->total_price / $cartProduct->prod_qty;
        $cartProduct->prod_qty++;
        $cartProduct->total_price = $divider * $cartProduct->prod_qty;

        $cartProduct->save();

        return true;
    }

    public function cartDecr(Request $request)
    {
        $default_qty = 1;

        $cartProduct = Cart::where('user_id', $request->user_id)->where('prod_id', $request->prod_id)->first();
        $divider = $cartProduct->total_price / $cartProduct->prod_qty;
        $cartProduct->prod_qty--;
        if ($cartProduct->prod_qty < 1) {
            $cartProduct->prod_qty = $default_qty;
        }
        $cartProduct->total_price = $divider * $cartProduct->prod_qty;
        $cartProduct->save();

        return true;
    }

    public function deleteProduct(Request $request)
    {
        $cartProduct = Cart::where('user_id', $request->user_id)->where('prod_id', $request->prod_id)->first();
        $cartProduct->delete();

        return true;
    }

    public function deleteUserCart(Request $request)
    {
        Cart::where('user_id', $request->user_id)->delete();
        return true;
    }
}
