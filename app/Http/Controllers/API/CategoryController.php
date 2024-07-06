<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getProducts(Request $request)
    {
        $categ = Category::where('category_name', $request->category)->first();

        $products = $categ->products()->get();

        foreach ($products as $product) {
            $average_rating = $product->ratings->avg('rating');
            $product['avg_product_rating'] = $average_rating;
        }

        return $products;
    }


    public function getCategory(Request $request)
    {
        $category = Category::where('id', $request->category_id)->first();
        return $category;
    }
}
