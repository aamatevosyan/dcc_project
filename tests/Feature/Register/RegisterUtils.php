<?php

namespace Tests\Feature\Register;

use App\Models\User;
use Cache;
use Str;

class RegisterUtils
{
    public static function getUuidFromResponse($response): string
    {
        $location = $response->headers->get('location');
        return substr($location, strripos($location, "/") + 1);
    }

    public static function getEmailVerificationCodeFromCache($uuid): string
    {
        $cacheKey = "auth.sendcode.email.{$uuid}";
        return Cache::get($cacheKey)['code'];
    }

    public static function hasEmailCodeInCache($uuid): bool
    {
        $cacheKey = "auth.sendcode.email.{$uuid}";
        return Cache::has($cacheKey);
    }

    public static function getPhoneVerificationCodeFromCache($uuid): string
    {
        $cacheKey = "auth.sendcode.phone.{$uuid}";
        return Cache::get($cacheKey)['code'];
    }

    public static function hasPhoneCodeInCache($uuid): bool
    {
        $cacheKey = "auth.sendcode.phone.{$uuid}";
        return Cache::has($cacheKey);
    }

    public static function createUser($email, $status, $phone = null): User
    {
        return User::create([
            'email' => $email,
            'uuid' => Str::uuid()->toString(),
            'status' => $status,
            'phone' => $phone
        ]);
    }
}
