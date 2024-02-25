<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return response()->json([
            'message' => count($users),
            'data' => $users,
            'status' => true
        ]);
    }
    public function getsinglerecord($id){
        $user = User::find($id);
        if ($user !=null){
            return response()->json([
                'message' => '1 User Found',
                'data' => $user,
                'status' => true
            ]);
        }
        else{
            return response()->json([
                'message' => 'No User Found',
                'status' => false
            ]);
        }
    }

public function update(Request $request, $id){
    $user = User::find($id);

    if($user == null){
        return response()->json([
            'message'=> 'Please fix the errors',
            'errors' => $validator->errors(),
            'status' => false
        ],200);
    }
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,'.$id,
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }


    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    return response()->json([
        'message' => 'User Updated Sucessfully',
        'data' => $user,
        'status'=> true
    ],200);
}

public function store(Request $request){
    $validator = Validator::make($request->all(),[
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required'    
    ]);

    if($validator->fails()){
        return response()->json([
            'message' => 'Please fix the errors',
            'errors' => $validator->errors(),
            'status' => false
        ],200);
    }

    $user = new User;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = $request->password;
    $user->save();
    return response()->json([
        'message' => 'User created successfully',
        'data' => $user,
        'status' => true
    ],200);
}

    public function destroy($id){
        $user = User::find($id);
        if ($user ==null){
            return response()->json([
                'message' => 'No User Found',
                'status' => false
            ],200);
        }
        else{
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully',
                'status' => true
            ],200);
        }
    }

    public function upload(Request $request){
        $validator = Validator::make($request->all(),[
            'image' =>'required|mimes:png,jpg,jpeg,gif'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Please fix this error',
                'status' => false,
                'errors' =>$validator->errors()
            ],200);
        }

        $img = $request->image;
        $ext = $img->getClientOriginalExtension();
        $imageName = time(). '.'.$ext;
        $img->move(public_path().'/uploads/',$imageName);
        $image = new Image;
        $image->image = $imageName;
        $image->save();
        return response()->json([
            'message' => 'Image Uploaded successfully',
            'data'=>$image,
            'path'=>asset('uploads/'.$imageName),
            'status' => true
        ],200);
    }









}
