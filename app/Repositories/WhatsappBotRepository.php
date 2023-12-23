<?php

namespace App\Repositories;

use App\Contract\Repositories\WhatsappBotRepositoryInterface;
use App\Models\WhatsappBot;

class WhatsappBotRepository implements WhatsappBotRepositoryInterface
{
    protected $model = WhatsappBot::class;


    /**
     * Get Bot
     */
    public function findBotByBotPhone(string $botPhone)
    {
        $bot = $this->model::with(['koperasi'])->where('wa_phone', $botPhone)->first();

        return $bot;
    }
}