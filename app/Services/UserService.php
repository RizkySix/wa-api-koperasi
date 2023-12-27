<?php

namespace App\Services;

use App\Contract\Repositories\UserRepositoryInterface;
use App\Contract\Services\GeneralWalletServiceInterface;
use App\Contract\Services\KoperasiServiceInterface;
use App\Contract\Services\UserServiceInterface;
use App\Contract\Services\WhatsappBotServiceInterface;
use App\Helper\AuthorizationWaApi;
use App\Ipaymu\IpaymuRegister;
use App\Mail\VerifyEmailUserMail;
use App\Models\Koperasi;
use App\Models\User;
use App\Traits\AuthenticationTrait;
use App\Traits\ListMessageTrait;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService implements UserServiceInterface
{
    use ListMessageTrait, AuthenticationTrait;
    protected $repository;
    protected $koperasiServiceInterface;
    protected $whatsappBotServiceInterface;
    protected $generalWalletServiceInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface, KoperasiServiceInterface $koperasiServiceInterface, WhatsappBotServiceInterface $whatsappBotServiceInterface, GeneralWalletServiceInterface $generalWalletServiceInterface)
    {
        $this->repository = $userRepositoryInterface;
        $this->koperasiServiceInterface = $koperasiServiceInterface;
        $this->whatsappBotServiceInterface = $whatsappBotServiceInterface;
        $this->generalWalletServiceInterface = $generalWalletServiceInterface;
    }

     /**
     * Koperasi nasabah proses registrasi
     */
    public function userRegister(array $data)
    {
       try {
      
        $data['phone'] = explode('@' , $data['phone'])[0];
        $data['password'] = $data['nik'] . rand(100,999);
        $data['hashed_password'] = Hash::make($data['password']);

        $user = $this->repository->userRegister([
            'nik' => $data['nik'],
            'password' => $data['hashed_password'],
            'phone' => $data['phone'],
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
        
        // attach user
       $attaching = $this->koperasiServiceInterface->attachUserWithKoperasi($data['bot_phone'] , $user);
      
       $getKoperasi = $this->whatsappBotServiceInterface->findBotByBotPhone($data['bot_phone']);

       $statusRegis = $this->sendRegisterMessage($attaching , $getKoperasi->app_key , $data['phone']);

        if(!$statusRegis){
            return false;
        }


        //mail action below start
        $emailPayload = [
           'phone' => $data['phone'],
           'koperasi_name' => $getKoperasi->koperasi->name,
           'email' => $data['email'],
           'name' => $data['name'],
        ];

       $this->setVerifyEmailPayload($emailPayload);
        
        //set ipaymu single sign on payload cache
        $this->setPayloadIpaymu([
            'phone' => $data['phone'],
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => $data['password'],
        ]);

        return $user;

       } catch (Exception $e) {
            Log::debug($e->getMessage());
            return $e->getMessage();
       }

    }


    /**
     * Resend verify email
     */
    public function resendEmailVerify(string $phone)
    {
        try {
            $getUser = $this->repository->findUserByPhone($phone);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * Verify email service
     */
    public function verifyEmail(string $email, string $token)
    {
        try {
            $email = str_replace('%40' , '@' , $email);
            $getCache = Cache::get('verify-email' . $email);

            if($getCache != null && $getCache['token'] == $token){
                $this->repository->verifyEmail($email);

                $getKoperasi = $this->koperasiServiceInterface->findKoperasiByBame($getCache['koperasi']);
              
                AuthorizationWaApi::seeBotSendMessage($getKoperasi->bot->app_key , $getCache['receiverPhone'], 'Email kamu berhasil terverifikasi');
                
                Cache::forget('verify-email' . $email);

                // action single sign on ipaymu
                $user = $this->findUserByPhone($getCache['receiverPhone']);

                $singleSignOnPayload = Cache::get('single-sign-on-' . $email);
                $singleSignOn = $this->generalWalletServiceInterface->storeIpaymuData($user , $singleSignOnPayload);

                if($singleSignOn){
                    AuthorizationWaApi::seeBotSendMessage($getKoperasi->bot->app_key , $singleSignOnPayload['phone'], $this->listOption());
                }

                return true;

            }

            return false;
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            return $e->getMessage();
        }
    }


    /**
     * Find user by phone
     */
    public function findUserByPhone(string $phone)
    {
        try {
            return $this->repository->findUserByPhone($phone);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}