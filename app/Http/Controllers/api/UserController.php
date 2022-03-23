<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        // show all users []
        $data = User::all();
        if(count($data) > 0){
            return response()->json(["data" => $data, "message" => "success", "status" => 200]);
        }else{
            return response()->json(["message" => "errors"]);
        }
    }

    public function store(Request $request)
    {
        // insert new user = post -> api/users
        $request->validate([
            "name" => "required|string",
            "email" => "required|email",
            "password" => "required",
        ]);
        $data = new User;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->save();
        return response()->json(["data" => $data, "message" => "success", "status" => 200]);
    }

    public function show($id)
    {
        // show one user = get -> api/users/1
        $data = User::find($id);
        if($data){
            return response()->json(["data" => $data, "message" => "success", "status" => 200]);
        }else{
            return response()->json(["message" => "errors"]);
        }
    }

    public function update(Request $request, $id)
    {
        // update user = post -> api/users/1     {{params}} _method => PUT    {{url}}/users/1?_method=PUT
        $request->validate([
            "name" => "required|string",
            "email" => "required|email",
            "password" => "required",
        ]);
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->save();
        return response()->json(["data" => $data, "message" => "success", "status" => 200]);
    }

    public function destroy($id)
    {
        // delete user
        $data = User::find($id);
        if($data){
            $data->delete();
            return response()->json(["data" => $data, "message" => "success", "status" => 200]);
        }
        return response()->json(["message" => "errors"]);
    }

    public function search($name)
    {
        // search
        $data = User::where("name", "like", "%" . $name . "%")->get();
        if(count($data) > 0){
            return response()->json(["data" => $data, "message" => "success", "status" => 200]);
        }
        return response()->json(["message" => "errors"]);
    }

}
