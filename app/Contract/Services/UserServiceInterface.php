<?php

namespace App\Contract\Services;

use App\Models\User;

interface UserServiceInterface
{
    public function userRegister(array $data);

    public function verifyEmail(string $email , string $token);

    public function resendEmailVerify(string $phone);

    public function findUserByPhone(string $phone);

    public function checkBalance(User $user);

    public function checkHistoryTransaction(User $user);

    public function deleteUnverifiedMail();
}