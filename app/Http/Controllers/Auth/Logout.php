<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Logout extends Controller
{
    public function __invoke(Request $request)
    {
        $request->user()->__invoke()->delete();
        return response()->json(['Logout'], 200);
    }
}
