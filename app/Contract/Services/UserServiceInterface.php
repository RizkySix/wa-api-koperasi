<?php

namespace App\Contract\Services;

interface UserServiceInterface
{
    public function userRegister(array $data);

    public function verifyEmail(string $email , string $token);

    public function resendEmailVerify(string $phone);

    public function findUserByPhone(string $phone);
}