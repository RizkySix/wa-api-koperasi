<?php

namespace App\Repositories;

use App\Contract\Repositories\GeneralWalletRepositoryInterface;
use App\Models\GeneralWallet;
use App\Models\User;

class GeneralWalletRepository implements GeneralWalletRepositoryInterface
{
    protected $model = GeneralWallet::class;
    
    /**
     * Store ipaymu data
     */
    public function storeIpaymuData(User $user, array $data)
    {
        $ipaymuData = $user->generalWallet()->create([
            'ipaymu_va' => $data['Va'],
            'ipaymu_email' => $data['Email'],
            'ipaymu_name' => $data['VaName'],
            'active_at' => now()
        ]);

        return $ipaymuData;
    }
}