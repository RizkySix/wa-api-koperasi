<?php

namespace App\Services;

use App\Contract\Repositories\UserRepositoryInterface;
use App\Contract\Services\KoperasiServiceInterface;
use App\Contract\Services\UserServiceInterface;
use App\Mail\VerifyEmailUserMail;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService implements UserServiceInterface
{
    protected $repository;
    protected $koperasiServiceInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface, KoperasiServiceInterface $koperasiServiceInterface)
    {
        $this->repository = $userRepositoryInterface;
        $this->koperasiServiceInterface = $koperasiServiceInterface;
    }

     /**
     * Koperasi nasabah proses registrasi
     */
    public function userRegister(array $data)
    {
       try {
        Log::debug($data);
        $data['phone'] = explode('@' , $data['phone'])[0];
        $data['password'] = Hash::make($data['nik'] . rand(100,999));

        $user = $this->repository->userRegister($data);
        
        // attach user
        $koperasi = $this->koperasiServiceInterface->findKoperasiByBotPhone('6285792718157')->koperasi->users()->attach($user);
        Log::debug($koperasi);


        //mail action below start
        $token = Str::uuid();

        // cache here
        Cache::remember('verify-email' . $data['email'] , now()->addHour(1) , function() {
            return null;
        });

        Cache::put('verify-email' . $data['email'] , $token, now()->addHour(1));

        $emailPayload = [
            'url' => 'http://api-koperasi.test/api/v1/auth/email/verify?email=' . str_replace( '@' ,'%40' , $data['email']) . '&token=' . $token,
            'name' => $data['name']
        ];

        Mail::to($data['email'])->send(new VerifyEmailUserMail($emailPayload));
        //end mail action 

        return $user;

       } catch (Exception $e) {
            Log::debug($e->getMessage());
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

            if($getCache && $getCache == $token){
                $this->repository->verifyEmail($email);
                return true;
            }

            return false;
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            return $e->getMessage();
        }
    }
}