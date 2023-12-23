<?php

namespace App\Contract\Services;

interface WhatsappBotServiceInterface
{
    public function findBotByBotPhone(string $botPhone);
}