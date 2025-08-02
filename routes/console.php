<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

Artisan::command('payment:inspect', function () {
    $payments = Payment::where("status", Payment::STATUS_PENDING)->get();
    foreach ($payments as $payment) {
        $user = $payment->user;
        if ($payment->transaction_id == null) {
            continue;
        }
        $response = Http::post("https://api.nokash.app/lapas-on-trans/trans/310/status-request?transaction_id=".$payment->transaction_id);
        if ($response->successful()) {
            $status = $response->json()["data"]["status"];
            switch ($status) {
                case "SUCCESS":
                    $payment->update(["status" => Payment::STATUS_SUCCEED]);
                    // Create the subscription for the payment.
                    Subscription::where("user_id", $user->id)->delete();
                    Subscription::create([
                        "user_id"    => $user->id,
                        "plan_id"    => $payment->plan_id,
                        "expired_at" => Carbon::now()->addDays(30),
                        "payment_id" => $payment->id,
                    ]);
                    break;
                case "PENDING":
                    $payment->update(["status" => Payment::STATUS_PENDING]);
                    break;
                case "FAILED":
                    $payment->update(["status" => Payment::STATUS_FAILED]);
                    break;
                case "CANCELED":
                    $payment->update(["status" => Payment::STATUS_FAILED]);
                    break;
                case "TIMEOUT":
                    $payment->update(["status" => Payment::STATUS_FAILED]);
                    break;
                default:
                    break;
            }
        } else {
            dump("Response nothing");
            // Send Error to Instagram Bot.
        }
    }
});



Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('demo', function () {

    DB::beginTransaction();
    DB::commit();
});
