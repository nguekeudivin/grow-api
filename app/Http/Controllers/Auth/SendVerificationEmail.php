<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SendVerificationEmail extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        if ($user->verified_at) {
            return response()->json(['message' => 'Email already verified.'], 400);
        }

        $emailToken = TokenService::generate([
            'id' => $user->id
        ]);
        $user->link = url('/verify/email?token='.$emailToken);
        Mail::to($user->email)->send(new AccountCreated($user));

        return response()->json(['message' => 'Verification email resent.']);
    }
}
