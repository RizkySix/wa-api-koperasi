<?php

namespace App\Http\Controllers;

use App\Contract\Services\KoperasiServiceInterface;
use App\Contract\Services\UserServiceInterface;
use App\Models\Koperasi;
use App\Models\User;
use App\Traits\ListMessageTrait;
use App\Traits\RegexFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    use RegexFormatTrait, ListMessageTrait;
    protected $koperasiServiceInterface;
    protected $userServiceInterface;

    public function __construct(KoperasiServiceInterface $koperasiServiceInterface, UserServiceInterface $userServiceInterface)
    {
        $this->koperasiServiceInterface = $koperasiServiceInterface;
        $this->userServiceInterface = $userServiceInterface;
    }



    /**
     * Wehbook for each koperasi
     */
    public function koperasiWebhook(Request $request)
    {
        $receiverPhone = explode('@' , $request->remote_id)[0];
        $findUser = User::where('phone' , $receiverPhone)->first();

        if(!$findUser && strpos($request->message,  'Anda belum terdaftar silahkan lengkapi form berikut dan kirim kembali.') === false){

            $this->koperasiServiceInterface->sendRegisterForm($receiverPhone);
            return;
        }

       switch ($request->message) {
        case '1':
            Log::debug(1);
            break;
        
        default:
            $payload = $this->getValue($request);
        
            $result = $this->userServiceInterface->userRegister($payload);
            Log::debug($result);
            return $this->koperasiServiceInterface->sendNotifVerifyEmailSend($receiverPhone);
           
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
