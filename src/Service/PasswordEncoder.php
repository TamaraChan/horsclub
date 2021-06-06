<?php


namespace App\Service;


class PasswordEncoder
{
    public function encode($password)
    {
        return md5($_ENV['APP_SECRET'] . $password);
    }
}