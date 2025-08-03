<?php

namespace App\Http\Controllers\Association;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Association;

class GetAssociations extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'associations' => Association::all()
        ]);
    }
}
