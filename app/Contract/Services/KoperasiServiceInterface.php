<?php

namespace App\Contract\Services;

use App\Models\User;

interface KoperasiServiceInterface
{
    public function optionRequest(array $request);

    public function sendList();

    public function sendMessage(string $msg);

    // -------------------------------------------------------------yang diatas tidak dipakai karena itu milik 1msgio
    public function attachUserWithKoperasi(string $botPhone, User $user);

    public function findKoperasiByBame(string $name);

    public function findKoperasiByPhone(string $phone);

    public function sendRegisterForm(string $botPhone, string $receiverPhone);

    public function sendNotifVerifyEmailSend(string $botPhone, string $receiverPhone);
}