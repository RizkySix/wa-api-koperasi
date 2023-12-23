<?php

namespace App\Services;

use App\Contract\Repositories\KoperasiRepositoryInterface;
use App\Contract\Services\KoperasiServiceInterface;
use App\Contract\Services\User as ServicesUser;
use App\Contract\Services\WhatsappBotServiceInterface;
use App\Helper\AuthorizationWaApi;
use App\Models\User;
use App\Models\WhatsappBot;
use App\Traits\ListMessageTrait;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KoperasiService implements KoperasiServiceInterface
{
    use ListMessageTrait;
    protected $repository;
    protected $whatsappBotServiceInterface;

    public function __construct(KoperasiRepositoryInterface $koperasiRepositoryInterface, WhatsappBotServiceInterface $whatsappBotServiceInterface)
    {
        $this->repository = $koperasiRepositoryInterface;
        $this->whatsappBotServiceInterface = $whatsappBotServiceInterface;
    }

    /**
     * 2 saldo, 3 transaksi terkahir, 4 belum register koperasi, 5 berhasil regis
     */
    public function optionRequest(array $request)
    {
        $option = 'null';
      
        $senderPhone = $request['messages'][0]['chatName'];
        $regisData = explode(':' , $request['messages'][0]['body']);
        
        $user = $this->repository->findUser($senderPhone);
        if(!$user && count($regisData) != 2 && $request['messages'][0]['self'] == 0){
            $option = 4;

        }elseif(count($regisData) == 2 && $request['messages'][0]['self'] == 0){
            $this->repository->registerUser();
            $option = 'list';

        }elseif(isset($request['messages'][0]['list_reply']['id'])){
            $option = $request['messages'][0]['list_reply']['id'];

        }elseif(isset($request['messages'][0]['self'])){
            $option = $request['messages'][0]['self'];
            $option = $option == 0 ? 'list' : 'null';
        }


        return $option;
    }


    public function sendList()
    {
        try {
            $list = $this->listMessage();
            AuthorizationWaApi::authorization()->post(env('CHANNEL_WA') . 'sendList' , $list);
            
            Log::debug('List Sent');
        } catch (Exception $e) {
           Log::debug($e->getMessage());
        }
    }


    public function sendMessage(string $msg)
    {
        try {
            $message = $this->message($msg);
            AuthorizationWaApi::authorization()->post(env('CHANNEL_WA') . 'sendMessage' , $message);

            Log::debug("Message sent");
        } catch (Exception $e) {
           Log::debug($e->getMessage());
        }
    }

    //------------------------------------------------------------------------------------------------------------------------

    /**
     * Attach user to koperasi
     */
    public function attachUserWithKoperasi(string $botPhone, User $user)
    {
        try {
            $bot = $this->whatsappBotServiceInterface->findBotByBotPhone($botPhone);
            Log::debug($bot);
         
            return $this->repository->attachUserWithKoperasi($bot, $user);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * Find koperasi by name
     */
    public function findKoperasiByBame(string $name)
    {
        try {
            return $this->repository->findKoperasiByBame($name);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * Find koperasi by phone
     */
    public function findKoperasiByPhone(string $phone)
    {
        try {
            return $this->repository->findKoperasiByPhone($phone);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }


    /**
     * Kirim form registrasi form ke nasabah
     */
    public function sendRegisterForm(string $botPhone, string $receiverPhone)
    {
        try {
            $getBot = $this->whatsappBotServiceInterface->findBotByBotPhone($botPhone);
            $response = AuthorizationWaApi::seeBotSendMessage($getBot->app_key , $receiverPhone , $this->registerNasabahForm());

            Log::debug($response);
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            return $e->getMessage();
        }
        
    }

    public function sendNotifVerifyEmailSend(string $botPhone, string $receiverPhone)
    {
        try {
            $getBot = $this->whatsappBotServiceInterface->findBotByBotPhone($botPhone);
            $response = AuthorizationWaApi::seeBotSendMessage($getBot->app_key , $receiverPhone , 'Kami sudah mengirim email verifikasi ke email kamu');

            Log::debug($response);
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            return $e->getMessage();
        }  
    }
}