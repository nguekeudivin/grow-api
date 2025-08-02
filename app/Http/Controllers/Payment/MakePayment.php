<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MakePayment extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'method' => 'required|in:ORANGE_MONEY,MTN_MOMO',
            'phone_number' => 'required|string|max:20',
            'status' => 'in:PENDING,FAILED,SUCCEED',
        ]);

        $user = Auth::user();

        $plan = Plan::findOrFail($request->plan_id);

        // Create a pending payment status.
        $payment = Payment::create([
            "user_id" => $user->id,
            "plan_id" => $request->plan_id,
            "amount" => $plan->price,
            "method" => $request->method,
            'phone_number' => $request->phone_number,
            "status" => Payment::STATUS_PENDING,
        ]);

        // The phone number is optional, if not provided we use the user's phone number.
        $paymentPhoneNumber = $request->has("phone_number") ? "237".$request->phone_number : "237".$user->phone_number;

        // Send the payment request to nokash.
        $response = Http::post("https://api.nokash.app/lapas-on-trans/trans/api-payin-request/407", [
            'i_space_key' => config('app.nokash_i_space_key'),
            'app_space_key' => config('app.nokash_app_space_key'),
            'amount' => "".$payment->amount."",
            'order_id' => $payment->id,
            'country' => 'CM',
            "payment_type" => "CM_MOBILEMONEY",
            'payment_method' => $payment->method,
            "user_data" => [
                "user_phone" => $paymentPhoneNumber,
            ]
        ]);

        // Handle the responseP
        if ($response->successful()) {
            // Update the financial transaction id.
            $data = $response->json();
            switch ($data["status"]) {
                case "REQUEST_OK":
                    $payment->transaction_id = $data['data']['id'];
                    $payment->save();
                    // A worker will now request the payment financial transaction an check if the status is complete.
                    DB::commit();
                    return response()->json($payment, 201);
                    break;
                case "REQUEST_BAD_INFOS":
                    return response()->json([
                        'status' => 'error',
                        'message' => $data['message'],
                    ], 400);
                    break;
                default:
                    return response()->json([
                        'status' => 'error',
                        'message' => $data['message'],
                    ], 400);
            }
        } else {
            return response()->json($response->body(), 500);
        }
    }
}
