<?php

namespace App\Http\Controllers\User;

use App\Contract\Repositories\GeneralWalletRepositoryInterface;
use App\Contract\Services\GeneralWalletServiceInterface;
use App\Contract\Services\KoperasiServiceInterface;
use App\Contract\Services\UserServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $koperasiServiceInterface;
    protected $userServiceInterface;
    protected $generalWalletServiceInterface;

    public function __construct(KoperasiServiceInterface $koperasiServiceInterface, UserServiceInterface $userServiceInterface, GeneralWalletServiceInterface $generalWalletServiceInterface)
    {
        $this->koperasiServiceInterface = $koperasiServiceInterface;
        $this->userServiceInterface = $userServiceInterface;
        $this->generalWalletServiceInterface = $generalWalletServiceInterface;
    }

    public function verifyEmail(Request $request)
    {
        $data = $this->userServiceInterface->verifyEmail($request->email, $request->token);
      
        Log::debug($data);
    }
}
