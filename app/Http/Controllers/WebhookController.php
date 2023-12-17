<?php

namespace App\Http\Controllers;

use App\Contract\Services\KoperasiServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    protected $koperasiServiceInterface;

    public function __construct(KoperasiServiceInterface $koperasiServiceInterface)
    {
        $this->koperasiServiceInterface = $koperasiServiceInterface;
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
                return $this->koperasiServiceInterface->sendMessage('Anda belum terdaftar, lakukan pendaftaran dengan cara ini. Nama Koperasi:Ini Koperasi');
                break;
            case 'list':
                return $this->koperasiServiceInterface->sendList();
                break;
           
        }
    }

   
}
