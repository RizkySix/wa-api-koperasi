<?php

namespace App\Contract\Services;

use App\Models\User;

interface GeneralWalletServiceInterface
{
    public function storeIpaymuData(User $user, array $cacheData);

    public function findWalletByNik(string $nik);
}