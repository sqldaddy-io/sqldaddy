<?php

namespace App\SandBox\infrastructure\Service;

class PasswordGenerator
{
    public function __invoke($length = 20): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' .
            '0123456789`-=~!@#$%^&*()<>?;';
        $str = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++)
            $str .= $chars[mt_rand(0, $max)];
        return $str;
    }
}
