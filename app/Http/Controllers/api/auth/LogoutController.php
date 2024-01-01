<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request) {

       auth()->User()->tokens()->delete();
        return response()->json([
            'message' => 'revoked',
        ]);
    }
}
