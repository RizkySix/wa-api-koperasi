<?php

namespace App\Http\Controllers;

use App\Contract\Services\KoperasiServiceInterface;
use App\Contract\Services\UserServiceInterface;
use App\Contract\Services\WhatsappBotServiceInterface;
use App\Helper\AuthorizationWaApi;
use App\Helper\HelperMethod;
use App\Models\Koperasi;
use App\Models\User;
use App\Models\WhatsappBot;
use App\Traits\AuthenticationTrait;
use App\Traits\ListMessageTrait;
use App\Traits\RegexFormatTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    use RegexFormatTrait, ListMessageTrait, AuthenticationTrait;
    protected $koperasiServiceInterface;
    protected $userServiceInterface;
    protected $whatsappBotServiceInterface;

    public function __construct(KoperasiServiceInterface $koperasiServiceInterface, UserServiceInterface $userServiceInterface, WhatsappBotServiceInterface $whatsappBotServiceInterface)
    {
        $this->koperasiServiceInterface = $koperasiServiceInterface;
        $this->userServiceInterface = $userServiceInterface;
        $this->whatsappBotServiceInterface = $whatsappBotServiceInterface;
    }



    /**
     * Wehbook for each koperasi
     */
    public function koperasiWebhook(Request $request)
    {
      
        $receiverPhone = HelperMethod::phoneUserFormat($request->remote_id);
        $option = 0;

        $payload = $request->get('payload');
        $findUser = $request->get('user');
        $findKoperasiBot = $request->get('koperasi_bot');
      
        

    if(!$findUser && ($payload['nik'] != null || $payload['name'] != null || $payload['email'] != null)){
            $option = 1;

    
    }elseif($findUser && count($findUser->koperasies()->wherePivot('koperasi_id', $findKoperasiBot->koperasi->id)->get()) != 0){
        $option = 2;
       
    }


    //switch case 
       switch ($option) {
        case 1:
            $result = $this->userServiceInterface->userRegister($payload);
            Log::debug($result);
            
            return $result instanceof User ? AuthorizationWaApi::seeBotSendMessage($findKoperasiBot->app_key , $receiverPhone, 'Kami sudah mengirimkan email verifikasi, ketik "resend" untuk mengirim ulang.') : null;
            break;
        case 2:
            $option = $this->listOption();
            AuthorizationWaApi::seeBotSendMessage($findKoperasiBot->app_key, $receiverPhone , $option);
            break;
          
       }
    }


   

    /**
     * Controller for webhook
     */
    public function webhook(Request $request)
    {
       
        $getOption = json_decode($request->getContent() , true);
        $option = $this->koperasiServiceInterface->optionRequest($getOption);
        
       
        switch ($option) {
            case 1:
                Log::debug('1');
                break;
            case 2:
                return $this->koperasiServiceInterface->sendMessage('Saldo anda saat ini Rp. 2.000.000');
                break;
            case 3:
                return $this->koperasiServiceInterface->sendMessage('Riwayat transaksi terakhir anda adalah membeli baju renang');
                break;
            case 4:
                return $this->koperasiServiceInterface->sendMessage('Anda belum terdaftar, lakukan pendaftaran dengan cara ini. Koperasi:Ini Koperasi');
                break;
            case 'list':
                return $this->koperasiServiceInterface->sendList();
                break;
           
        }
    }

   
}
