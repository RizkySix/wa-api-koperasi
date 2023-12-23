<?php

namespace App\Repositories;

use App\Contract\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $model = User::class;

    /**
     * Koperasi nasabah proses registrasi
     */
    public function userRegister(array $data)
    {
        $user = $this->model::create($data);
        
        return $user;
    }

    /**
     * Verify Email
     */
    public function verifyEmail(string $email)
    {
       $user = $this->model::where('email' , $email)->update([
            'email_verified_at' => now()
        ]);

        return $user;
    }

    /**
     * find user by their phone
     */
    public function findUserByPhone(string $phone)
    {
        return $this->model::where('phone' , $phone)->first();
    }
}
