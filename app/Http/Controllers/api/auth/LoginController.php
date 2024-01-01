<?php

namespace App\Http\Controllers\api\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller {
    public function login(LoginRequest $request) {

        $user = User::where('email', $request->email)->first();
        if (!$user || ! \Hash::check($request->password,$user->password)) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Incorrect credentials',
            ], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }
}
