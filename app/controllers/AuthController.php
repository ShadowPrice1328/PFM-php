<?php

namespace controllers;

class AuthController
{
    public function index(): void
    {
        include_once(__DIR__ . '/../views/auth/index.php');
    }
}