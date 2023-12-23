<?php

namespace App\Contract\Repositories;

interface UserRepositoryInterface
{
    public function userRegister(array $data);

    public function verifyEmail(string $email);

    public function findUserByPhone(string $phone);
}