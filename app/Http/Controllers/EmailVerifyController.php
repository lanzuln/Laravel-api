<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailVerifyController extends Controller {
    public function verifyEmailSend() {

        Mail::to(auth()->user())->send(new EmailVerification(auth()->user()));

        return response()->json([
            'status' => 'success',
            'message' => 'Email verification link send to your email',
        ]);
    }

    public function verifyEmail() {

        if (!auth()->user()->email_verified_at) {
            User::where('id', auth()->user()->id)->update([
                'email_verified_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Email verification successfull',
            ]);
        }
    }
}
