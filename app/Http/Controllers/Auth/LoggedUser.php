<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoggedUser extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $user->permissions = $user->getPermissions();
        $user->load('admin', 'image', 'interests');
        return response()->json($user, 200);
    }
}
