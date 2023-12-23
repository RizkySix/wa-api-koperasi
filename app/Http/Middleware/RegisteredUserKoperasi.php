<?php

namespace App\Http\Middleware;

use App\Contract\Services\KoperasiServiceInterface;
use App\Helper\AuthorizationWaApi;
use App\Helper\HelperMethod;
use App\Traits\AuthenticationTrait;
use App\Traits\RegexFormatTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RegisteredUserKoperasi
{
    use AuthenticationTrait, RegexFormatTrait;
    private $koperasiServiceInterface;

    public function __construct(KoperasiServiceInterface $koperasiServiceInterface)
    {
        $this->koperasiServiceInterface = $koperasiServiceInterface;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = $request->get('user');
        $koperasiBot = $request->get('koperasi_bot');
        $payload = $request->get('payload');

        if($user && count($user->koperasies()->wherePivot('koperasi_id', 2)->get()) == 0){
            $decisionRegis = HelperMethod::makeAllStringLowerCase($request->message);
        
            if (!in_array($decisionRegis, ['lanjut', 'tidak']) && ($payload['nik'] != null || $payload['name'] != null || $payload['email'] != null)) {
                
                AuthorizationWaApi::seeBotSendMessage($koperasiBot->app_key , $user->phone , "Datamu sudah tersimpan di sistem kami. Balas 'Lanjut' jika ingin lanjut registrasi, balas 'Tidak' jika tidak.");
                return response('new register' , 403);
           }
          
           if($decisionRegis == 'lanjut'){
                $attaching = $this->koperasiServiceInterface->attachUserWithKoperasi($koperasiBot->wa_phone, $user);
                $this->sendRegisterMessage($attaching , $koperasiBot->app_key , $user->phone);

                
           }
    
        }

        return $next($request);
    }
}
