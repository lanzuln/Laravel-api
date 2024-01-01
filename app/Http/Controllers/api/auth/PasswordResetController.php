<?php

namespace App\Http\Controllers\api\auth;

use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ResetPassword_link;

class PasswordResetController extends Controller
{
    public function resetPasswordLink(ResetPassword_link $request){
        $url= URL::temporarySignedRoute('reset.Password.Link', now()->addMinutes(30),['email'=>$request->email]);
        // dd($url);

        // $url= str_replace(env('APP_URL'), 'https://laravel.com/',$url);
        // dd($url);

        Mail::to($request->email)->send(new ResetPasswordMail($url));

        return response()->json([
            'message' => 'Reset mail send succrssfull',
        ]);
    }
}
