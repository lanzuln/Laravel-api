<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class categoryController extends Controller
{
    public function index(){

        return response()->json([
            'status'=>'200',
            'message'=>"welcome to laravel api development"
        ]);
    }
}
