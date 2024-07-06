<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function getAllAds()
    {
        $ads =  Advertisement::all();
        return response()->json([
            'ads' => $ads
        ],200);
    }
}
