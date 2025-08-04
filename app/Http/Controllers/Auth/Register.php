<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Location;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Mail;
// use App\Mail\AccountCreated;
// use App\Services\TokenService;

class Register extends Controller
{
    public function __invoke(Request $request)
    {
        // Validate request data
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email|unique:users,email',
        //     'firstname' => 'required|string|max:255',
        //     'lastname' => 'required|string|max:255',
        //     'phone_number' => 'required|string|unique:users,phone_number|regex:/^6[5-9][0-9]{7}$/',
        //     'gender' => 'required|in:MALE,FEMALE',
        //     'birth_date' => 'nullable|date',
        //     'pin' => 'required|string|min:4',

        //     'city' => 'required|string',
        //     'address' => 'required|string',
        //     'country_id' => 'required|exists:countries,id',

        //     'region_origin_id' => 'nullable|exists:divisions,id',
        //     'department_origin_id' => 'nullable|exists:divisions,id',
        //     'arrondissement_origin_id' => 'nullable|exists:divisions,id',
        //     'village_origin_id' => 'nullable|exists:divisions,id',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['message' => $validator->errors()], 422);
        // }

        DB::beginTransaction();

        try {
            // Create user
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->pin),
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'phone_number' => $request->phone_number,
            ]);

            // Create current residence location
            $location = Location::create([
                'city' => $request->city,
                'street' => $request->address,
                'country_id' => $request->country_id,
            ]);
            $user->location_id = $location->id;

            // Determine origin division
            $divisionId = $request->region_origin_id;

            if ($request->filled('department_origin_id')) {
                $divisionId = $request->department_origin_id;
            }
            if ($request->filled('arrondissement_origin_id')) {
                $divisionId = $request->arrondissement_origin_id;
            }
            if ($request->filled('village_origin_id')) {
                $divisionId = $request->village_origin_id;
            }

            // Fetch Cameroon country (default)
            $cameroon = Country::where('code', 'CM')->firstOrFail();

            // Create origin location
            $originLocation = Location::create([
                'country_id' => $cameroon->id,
                'division_id' => $divisionId,
            ]);
            $user->origin_location_id = $originLocation->id;

            $user->save();

            // Generate token
            $user->token = $user->createToken('api-token')->plainTextToken;

            // Optionally send verification email
            /*
            try {
                $emailToken = TokenService::generate(['id' => $user->id]);
                $user->link = url('/verify/email?token=' . $emailToken);
                Mail::to($user->email)->send(new AccountCreated($user));
            } catch (\Exception $e) {
                // Handle email failure silently
            }
            */

            DB::commit();
            return response()->json($user, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
        }
    }
}
