<?php

namespace App\Contract\Services;

interface KoperasiServiceInterface
{
    public function optionRequest(array $request);

    public function sendList();

    public function sendMessage(string $msg);

    public function findKoperasiByBotPhone(string $botPhone);

    public function sendRegisterForm(string $receiverPhone);

    public function sendNotifVerifyEmailSend(string $receiverPhone);
}