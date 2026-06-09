<?php

namespace App\Support;

class ResetPasswordCode
{
    public static function generate(): string
    {
        return (string) random_int(100000, 999999);
    }

    public static function normalize(string $code): string
    {
        return preg_replace('/\D/', '', $code);
    }
}
