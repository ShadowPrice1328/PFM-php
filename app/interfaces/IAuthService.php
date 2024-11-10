<?php

namespace interfaces;

interface IAuthService
{
    public function authenticate($username, $password);
    public function getUserIdByUsername($username);
    public function registerUser($email, $username, $password) : bool;
}