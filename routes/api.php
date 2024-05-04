<?php

use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\OrdersController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/register', [UserController::class,'register']);
Route::post('/verifyOtp', [UserController::class,'verifyOtp']);
Route::post('/login', [UserController::class,'login']);
Route::get('/getProducts', [CategoryController::class, 'getProducts']);
Route::get('/category', [CategoryController::class, 'getCategory']);
Route::get('/getCarts', [CartController::class, 'getCarts']);
Route::get('/retrieveOrders', [OrdersController::class, 'getOrders']);
Route::get('/getUserBooks', [BookingController::class, 'getUserBookings']);
Route::put('/changeBookStatus', [BookingController::class, 'changeBookStatus']);
Route::get('/getAllProducts', [ProductController::class, 'getAllProducts']);






Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', [UserController::class,'getUser']);
    Route::post('/addToCart', [ProductController::class, 'addProductToCart']);
    Route::post('/incrCart', [CartController::class, 'cartIncr']);
    Route::post('/decrCart', [CartController::class, 'cartDecr']);
    Route::delete('/deleteProduct', [CartController::class, 'deleteProduct']);
    Route::post('/placeOrder', [OrdersController::class, 'placeOrder']);
    Route::delete('/deleteUserCart', [CartController::class, 'deleteUserCart']);
    Route::post('/bookTable', [BookingController::class, 'bookTable']);
    Route::post('/storeFavs', [ProductController::class, 'storeFavs']);
   
    

});
