<?php

namespace services;

class SessionManager
{
    public static function start(): void
    {
        if (session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
    }

    public static function getUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }
}