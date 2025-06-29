<?php

namespace App\Support\Helpers;

class RandomHelper
{
    public static function randomCode(?string $model = null, ?string $key = null)
    {
        $random = self::createRandomCode();
        if ($model && $key) {
            if ($model::where($key, $random)->exists()) {
                $random = self::randomCode($model, $key);
            }
        }

        return $random;
    }

    public static function createRandomCode()
    {
        return self::randomChar().rand(100000, 999999);
    }

    public static function randomChar()
    {
        $rand = rand(0, 25);

        return strtoupper(chr(65 + $rand));
    }

    public static function randomVerifyCode()
    {
        return random_int(100000, 999999);
    }

    public static function randomHash()
    {
        return md5(random_int(100000, 999999));
    }
}
