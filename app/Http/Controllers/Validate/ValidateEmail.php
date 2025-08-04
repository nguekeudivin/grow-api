<?php

namespace App\Http\Controllers\Validate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ValidateEmail extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user == null) {
            return response()->json([
                'status' => true
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "There is already an account with this email address"
            ], 422);
        }

    }
}
