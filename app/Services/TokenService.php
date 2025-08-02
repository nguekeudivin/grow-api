<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class TokenService
{
    public static $secret = "grow_";

    /**
     *  Generate a token
     *
     *  @param mixed $data
     *  @param integer $expirationTime
     *  @return
     */
    public static function generate($data, $expirationTime = null)
    {
        $payload = [
            "iss" => "localhost",
            "iat" => time(),
            "data" => $data,
        ];

        if ($expirationTime != null) {
            $payload["exp"] = time() + $expirationTime;
        }

        return JWT::encode($payload, self::$secret, "HS256");
    }

    public static function decode($token)
    {
        try {
            $decoded = JWT::decode($token, new Key(self::$secret, "HS256"));
            return $decoded->data;
        } catch (ExpiredException $e) {
            return null;
        }
    }

    /**
     *  Email is use as identifier.
     */
    public static function verify($request)
    {
        $bearerHeader = $request->header("Authorization");
        if ($bearerHeader == null) {
            return false;
        }

        $bearer = explode(" ", $bearerHeader);

        if (empty($bearer)) {
            return false;
        }

        if ($bearer[0] != "Bearer") {
            return false;
        }

        $bearerToken = $bearer[1];

        try {
            $decoded = JWT::decode($bearerToken, new Key(self::$secret, "HS256"));

            $data = $decoded->data;

            $user = User::select("id")
                ->where("id", "=", $data->id)
                ->first();

            if ($user == null) {
                return false;
            } else {
                $request->query->set("user_id", $user->id);
                return true;
            }
        } catch (Exception $e) {
            return false;
        }

    }

    public static function user($request)
    {

        $bearerHeader = $request->header("Authorization");
        if ($bearerHeader == null) {
            return null;
        }

        $bearer = explode(" ", $bearerHeader);

        if (empty($bearer)) {
            return null;
        }

        if ($bearer[0] != "Bearer") {
            return null;
        }

        $bearerToken = $bearer[1];

        $decoded = JWT::decode($bearerToken, new Key(self::$secret, "HS256"));

        $data = $decoded->data;

        return User::where("id", "=", $data->id)
            ->first()->makeHidden("password");
    }

}
