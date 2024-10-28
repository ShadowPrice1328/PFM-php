<?php

namespace models;

class Guid
{
    public static function createGUID(): string
    {
        // Create a token
        $token      = $_SERVER['HTTP_HOST'];
        $token     .= $_SERVER['REQUEST_URI'];
        $token     .= uniqid(rand(), true);

        // GUID is 128-bit hex
        $hash        = strtoupper(md5($token));

        $guid        = '';

        $guid .= substr($hash,  0,  8) .
            '-' .
            substr($hash,  8,  4) .
            '-' .
            substr($hash, 12,  4) .
            '-' .
            substr($hash, 16,  4) .
            '-' .
            substr($hash, 20, 12);

        return $guid;
    }
}