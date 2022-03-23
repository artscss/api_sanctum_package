<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// register new user
Route::post("register", [AuthController::class, "register"]);

// login user
Route::post("login", [AuthController::class, "login"]);

Route::group(["middleware" => ["auth:sanctum"]], function(){

// get all users
Route::get("users", [UserController::class, "index"]);

// get one user
Route::get("users/{id}", [UserController::class, "show"]);

// update user
Route::put("users/{id}", [UserController::class, "update"]);

// update user
Route::delete("users/{id}", [UserController::class, "destroy"]);

// search
Route::get("users/search/{name}", [UserController::class, "search"]);

// logout user
Route::post("logout", [AuthController::class, "logout"]);

});