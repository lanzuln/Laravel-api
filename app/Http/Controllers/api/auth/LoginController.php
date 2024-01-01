<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller {
    public function login(Request $request) {

        $user = User::where('email', $request->email)->first();
        if (!$user || Hash::check($user->password, $request->password)) {
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
