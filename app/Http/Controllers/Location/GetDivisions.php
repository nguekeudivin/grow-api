<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Division;

class GetDivisions extends Controller
{
    public function __invoke(Request $request)
    {
        $country = Country::where('code', 'CM')->first();
        $divisions = Division::where('country_id', $country->id)->get()->groupBy('type');
        return response()->json([
            'divisions' => $divisions
        ]);
    }
}
