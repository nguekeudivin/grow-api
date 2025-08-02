<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Register extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'email' => 'required|email|unique:users,email',
           'gender' => 'required|in:MALE,FEMALE',
           'password' => 'required|string|min:6',
           'firstname' => 'required|string|max:255',
           'lastname' => 'required|string|max:255',
           'lang' => 'nullable|in:fr,en',
           'phone_number' => 'required|string|unique:users,phone_number|regex:/^6[5-9][0-9]{7}$/'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'gender' => $request->gender,
            'lang' => $request->lang ?? "en",
            'phone_number' => $request->phone_number,
            'last_online' => now(),
        ]);

        // Create the api login token.
        $user->token = $user->createToken('api-token')->plainTextToken;

        // Send the mail.
        try {

            // Create the email token.
            $emailToken = TokenService::generate([
                'id' => $user->id
            ]);
            $user->link = url('/verify/email?token='.$emailToken);

            Mail::to($user->email)->send(new AccountCreated($user));
        } catch (Exception $e) {
            return response()->json($user, 200);
        }

        DB::commit();

        return response()->json($user, 200);
    }
}
