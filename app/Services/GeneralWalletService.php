<?php

namespace App\Services;

use App\Contract\Repositories\GeneralWalletRepositoryInterface;
use App\Contract\Services\GeneralWalletServiceInterface;
use App\Ipaymu\IpaymuRegister;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GeneralWalletService implements GeneralWalletServiceInterface
{
    protected $repository;
    public function __construct(GeneralWalletRepositoryInterface $generalWalletRepositoryInterface)
    {
        $this->repository = $generalWalletRepositoryInterface;
    }

    /**
     * Store ipaymu data
     */
    public function storeIpaymuData(User $user, array $cacheData)
    {
        try {
            
            //register single sign on ipaymu
           $singleSignOn = IpaymuRegister::singleSignOn($cacheData);
            Log::debug($singleSignOn);

            if($singleSignOn['Status'] == 200){
                $ipaymuData = $this->repository->storeIpaymuData($user , $singleSignOn['Data']);
                
                Cache::forget('single-sign-on-' . $cacheData['email']);
                Log::debug($ipaymuData);

                return true;
            }

            return false;
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            return $e->getMessage();
        }
    }


    /**
     * Find wallet by nik user
     */
    public function findWalletByNik(string $nik)
    {
        
    }
}