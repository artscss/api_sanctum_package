<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        if(count($data) > 0){
            return response()->json(["data" => $data, "message" => "success", "status" => 200]);
        }else{
            return response()->json(["message" => "errors"]);
        }
    }

    public function show(Request $request)
    {
        $data = $request->user();
        if($data){
            return response()->json(["data" => $data, "message" => "success", "status" => 200]);
        }else{
            return response()->json(["message" => "errors"]);
        }
    }

    public function update(Request $request)
    {        
        $request->validate([
            "name" => "string|nullable|min:3",
            "email" => "email|nullable",
            "phone" => "min:11|string|nullable",
            "image" => "url|nullable",
            "age" => "between:11,80|numeric|nullable",
            "address" => "string|nullable",
        ]);

        $data = $request->user();

        if(!empty($request->name) ){
            $data->name = $request->name;
        }
        if(!empty($request->email)){
            $data->email = Str::of($request->email)->lower();
        }
        if(!empty($request->password)){
            $data->password = Hash::make($request->password);
        }
        if(!empty($request->phone)){
            $data->phone = $request->phone;
        }
        // if($request->hasFile("image") && $data->image !== null)
        // {
        //     if($data->image !== "avatar.png"){
        //         unlink(public_path("images/") . $data->image);
        //     }

        //     $image = $request->file("image");
        //     $extension = $image->getClientOriginalExtension();
        //     $image_name = uniqid() . "." . $extension;
        //     $image->move(public_path("images/"), $image_name);
        //     $data->image = $image_name;
        // }
        
        if(!empty($request->image)){
            $data->image = $request->image;
        }
        if(!empty($request->age)){
            $data->age = $request->age;
        }
        if(!empty($request->address)){
            $data->address = $request->address;
        }

        $data->save();
        return response()->json(["data" => $data, "message" => "success", "status" => 200]);
    }

    public function destroy(Request $request)
    {
        $data = $request->user();
        if($data){
            $data->delete();
            return response()->json(["data" => $data, "message" => "success", "status" => 200]);
        }
        return response()->json(["message" => "errors"]);
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
