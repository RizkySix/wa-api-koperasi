<?php

namespace App\Repositories;

use App\Contract\Repositories\KoperasiRepositoryInterface;
use App\Models\User;

class KoperasiRepository implements KoperasiRepositoryInterface
{
    protected $model = User::class;

    public function findUser(string $senderPhone)
    {
        $user = $this->model::where('phone' , $senderPhone)->first();

        return $user;
    }

    public function registerUser()
    {
        $this->model::factory()->create(['phone' => env('TEST_PHONE')]);
    }


}