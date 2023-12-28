<?php

namespace App\Jobs;

use App\Contract\Services\UserServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DestroyUnverifiedEmailUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;
    public $backoff = 1;
    
    private $userServiceInterface;

    /**
     * Create a new job instance.
     */
    public function __construct(UserServiceInterface $userServiceInterface)
    {
       $this->userServiceInterface = $userServiceInterface;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->userServiceInterface->deleteUnverifiedMail();
    }
}
