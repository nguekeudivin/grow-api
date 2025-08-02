<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerifyPasswordResetToken extends Controller
{
    public function __invoke(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect()->to(env('WEB_CLIENT_URL') . "/auth/login/?m=Invalid or missing token");
        }

        $data = TokenService::decode($token);

        if (!$data) {
            return redirect()->to(env('WEB_CLIENT_URL') . "/auth/login/?m=Invalid or expired token");
        }

        return redirect()->to(env('WEB_CLIENT_URL') . "/auth/reset-password?token={$token}");
    }

}
