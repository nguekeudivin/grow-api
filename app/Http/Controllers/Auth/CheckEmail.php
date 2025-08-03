<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckEmail extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            // 'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email address'
            ]);
        }

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user->load('admin');

        $user->token = $user->createToken('api-token')->plainTextToken;

        // $user->permissions = $user->getPermissions();
        return response()->json($user, 200);
    }
}
