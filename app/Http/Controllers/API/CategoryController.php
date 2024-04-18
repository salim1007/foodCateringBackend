<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
        public function getProducts(Request $request){
            $products = array();

            $categ = Category::where('category_name', $request->category)->first();
            $products = Product::where('category_id', $categ->id)->get();
            return $products;

        }

        public function getCategory(Request $request){
            $request->validate([
                'category_id' => 'required'
            ]);
            
            $category = Category::where('id', $request->category_id)->first();
            return $category;
        }


 

}
