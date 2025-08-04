<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class GetCountries extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'countries' => Country::all()
        ]);
    }
}
