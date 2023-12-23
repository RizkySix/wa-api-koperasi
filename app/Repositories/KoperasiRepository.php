<?php

namespace App\Repositories;

use App\Contract\Repositories\KoperasiRepositoryInterface;
use App\Models\Koperasi;
use App\Models\User;
use App\Models\WhatsappBot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class KoperasiRepository implements KoperasiRepositoryInterface
{
    protected $model = Koperasi::class;
    protected $modelUser = User::class;

    public function findUser(string $senderPhone)
    {
        $user = $this->modelUser::where('phone' , $senderPhone)->first();

        return $user;
    }

    public function registerUser()
    {
        $this->modelUser::factory()->create(['phone' => env('TEST_PHONE')]);
    }



    /**
     * Attach user by koperasi
     */
    public function attachUserWithKoperasi(WhatsappBot $bot, User $user)
    {
        $data = $bot->koperasi->users()->attach($user);
        Log::debug($data);

        return $data;
    }


    /**
     * Find koperasi byname
     */
    public function findKoperasiByBame(string $name)
    {
        return $this->model::with(['bot'])->where('name' , $name)->first();
    }

    /**
     * Find koperasi by phone
     */
    public function findKoperasiByPhone(string $phone)
    {
        return $this->model::with(['bot'])->where('phone' , $phone)->first();
    }
}