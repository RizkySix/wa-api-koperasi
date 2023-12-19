<?php

namespace App\Http\Controllers\User;

use App\Contract\Services\KoperasiServiceInterface;
use App\Contract\Services\UserServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $koperasiServiceInterface;
    protected $userServiceInterface;

    public function __construct(KoperasiServiceInterface $koperasiServiceInterface, UserServiceInterface $userServiceInterface)
    {
        $this->koperasiServiceInterface = $koperasiServiceInterface;
        $this->userServiceInterface = $userServiceInterface;
    }

    public function verifyEmail(Request $request)
    {
        $data = $this->userServiceInterface->verifyEmail($request->email, $request->token);
        Log::debug($data);
    }
}
