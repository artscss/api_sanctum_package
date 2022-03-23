<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // register user
        $fields = $request->validate([
            "name" => "required|string",
            "email" => "required|string|unique:users|email",
            "password" => "required|string|confirmed",
            "phone" => "min:11|numeric",
        ]);
        $user = User::create([
            "name" => $fields["name"],
            "email" => $fields["email"],
            "password" => bcrypt($fields["password"]),
            "phone" => $fields["phone"],
        ]);

        $token = $user->createToken("myapptoken")->plainTextToken;
        $response = ["user" => $user, "token" => $token];
        return response($response, 201);
    }

    public function login(Request $request)
    {
        // login user
        $fields = $request->validate([
            "email" => "required|string",
            "password" => "required|string",
        ]);

        $user = User::where("email", $fields["email"])->first();

        if(!$user || !Hash::check($fields["password"], $user->password)){
            return response("data error", 401);
        };

        $token = $user->createToken("myapptoken")->plainTextToken;
        $response = ["user" => $user, "token" => $token];
        return response($response, 201);
    }

    public function logout()
    {
        // logout user
        auth()->user()->tokens()->delete();
        return response()->json('Successfully logged out');
    }

}