<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        if(count($data) > 0){
            return response()->json(["data" => $data, "message" => "success", "status" => 200], 200);
        }else{
            return response()->json(["message" => "errors"], 400);
        }
    }

    public function show(Request $request)
    {
        $data = $request->user();
        if($data){
            return response()->json(["data" => $data, "message" => "success", "status" => 200], 200);
        }else{
            return response()->json(["message" => "errors"], 400);
        }
    }

    public function update(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            "name" => "string|min:3|max:15",
            "email" => "email|unique:users,email",
            "phone" => "numeric|digits:11",
            "age" => "between:11,80|numeric|nullable",
            "address" => "string|max:255",      
            "image" => "image|mimes:png,jpg",
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $data = User::find(Auth::user()->id);

        if($data)
        {
            if(!empty($request->name)){
                $data->name = $request->name;
            }
            if(!empty($request->email)){
                $data->email = Str::of($request->email)->lower();
            }
            if(!empty($request->phone)){
                $data->phone = $request->phone;
            }
            if(!empty($request->age)){
                $data->age = $request->age;
            }
            if(!empty($request->password)){
                $data->password = Hash::make($request->password);
            }
            if(!empty($request->address)){
                $data->address = $request->address;
            }
    
            if($request->hasFile("image")){
                // if($data->image !== "avatar.png"){
                //     unlink(public_path("images/") . $data->image);
                // }
                $image = $request->file("image");
                $extension = $image->getClientOriginalExtension();
                $image_name = uniqid() . "." . $extension;
                $image->move(public_path("images/"), $image_name);
                $data->image = $image_name;
            }
            $data->save();

            return response()->json(["data" => $data, "message" => "success", "status" => 200], 200);
        }
        return response()->json(["message" => "errors"], 400);
    }

    public function destroy(Request $request)
    {
        $data = $request->user();
        if($data){
            if($data->image !== "avatar.png"){
                unlink(public_path("images/") . $data->image);
            }
            $data->delete();
            return response()->json(["data" => $data, "message" => "success", "status" => 200], 200);
        }
        return response()->json(["message" => "errors"], 400);
    }

    // public function search($name)
    // {
    //     // search for user
    //     $data = User::where("name", "like", "%" . $name . "%")->get();
    //     if(count($data) > 0){
    //         return response()->json(["data" => $data, "message" => "success", "status" => 200]);
    //     }
    //     return response()->json(["message" => "errors"]);
    // }

}
