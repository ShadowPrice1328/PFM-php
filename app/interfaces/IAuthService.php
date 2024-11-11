<?php

namespace interfaces;

interface IAuthService
{
    public function authenticate($email, $password);
    public function getUserIdByUsername($username);
    public function getUserIdByEmail($email);
    public function registerUser($email, $username, $password) : bool;
}