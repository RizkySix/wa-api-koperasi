<?php

namespace App\Services;

use App\Contract\Repositories\WhatsappBotRepositoryInterface;
use App\Contract\Services\WhatsappBotServiceInterface;
use Exception;

class WhatsappBotService implements WhatsappBotServiceInterface
{
    protected $repository;

    public function __construct(WhatsappBotRepositoryInterface $whatsappBotRepositoryInterface)
    {
        $this->repository = $whatsappBotRepositoryInterface;
    }

    /**
     * Get bot 
     */
    public function findBotByBotPhone(string $botPhone)
    {
        try {
            return $this->repository->findBotByBotPhone($botPhone);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}