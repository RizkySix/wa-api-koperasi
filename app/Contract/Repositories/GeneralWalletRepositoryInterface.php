<?php

namespace App\Contract\Repositories;

use App\Models\User;

interface GeneralWalletRepositoryInterface
{
    public function storeIpaymuData(User $user, array $data);
}