<?php

namespace App\Contract\Repositories;

interface WhatsappBotRepositoryInterface
{
    public function findBotByBotPhone(string $botPhone);
}