<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\passwordReset;
use App\Http\Requests\ResetPassword_link;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class PasswordResetController extends Controller {
    public function resetPasswordLink(ResetPassword_link $request) {
        $url = URL::temporarySignedRoute('reset.Password.Link', now()->addMinutes(30), ['email' => $request->email]);
        // dd($url);

        // $url= str_replace(env('APP_URL'), 'https://laravel.com/',$url);
        // dd($url);

        // $url='https://laravel.com/';

        Mail::to($request->email)->send(new ResetPasswordMail($url));

        return response()->json([
            'message' => 'Reset mail send successfull',
        ]);
    }

    public function resetPassword(passwordReset $request) {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'Fail',
                'message' => 'Email not found',
            ]);
        }
        User::where('password',$user->password)->update([
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Password reset successfull',
        ]);

    }
}
