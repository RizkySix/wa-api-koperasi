<?php

namespace App\Contract\Repositories;

interface KoperasiRepositoryInterface
{
    public function findUser(string $senderPhone);

    public function registerUser();

}