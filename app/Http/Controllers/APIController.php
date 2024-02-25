<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function index(){
        $array = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com'
            ],            
            [
                'name' => 'Mark Doe',
                'email' => 'john@example.com'
            ],            
            [
                'name' => 'Stark Doe',
                'email' => 'john@example.com'
            ]
            ];
            return response()->json([
                'message'=>'3 User Found',
                'data' => $array,
                'status' =>true
            ],200);

    }
}
