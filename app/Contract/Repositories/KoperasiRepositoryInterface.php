<?php

namespace App\Contract\Repositories;

use App\Models\User;
use App\Models\WhatsappBot;
use Illuminate\Database\Eloquent\Collection;

interface KoperasiRepositoryInterface
{
    public function findUser(string $senderPhone);

    public function registerUser();

    public function attachUserWithKoperasi(WhatsappBot $bot, User $user);

    public function findKoperasiByBame(string $name);

    public function findKoperasiByPhone(string $phone);
    
}