<?php

namespace interfaces;

interface IAuthService
{
    public function authenticate($username, $password);
    public function getUserIdByUsername($username);
}