<?php

namespace App\Http\Middleware;

use App\Helper\AuthorizationWaApi;
use App\Helper\HelperMethod;
use App\Traits\AuthenticationTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedUserEmail
{
    use AuthenticationTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = $request->get('user');
        $koperasiBot = $request->get('koperasi_bot');

        $message = HelperMethod::makeAllStringLowerCase($request->message);

        if($user && $user->email_verified_at == null){
            if($message == 'resend'){
                $dataEmail = [
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'koperasi_name' => $koperasiBot->koperasi->name,
                    'name' => $user->name
                ];
                
                $this->setVerifyEmailPayload($dataEmail);
                AuthorizationWaApi::seeBotSendMessage($koperasiBot->app_key , $user->phone, 'Kami sudah mengirimkan email verifikasi, ketik "resend" untuk mengirim ulang.');

                return response('resend email verification' , 201);
            }

             AuthorizationWaApi::seeBotSendMessage($koperasiBot->app_key , $user->phone, 'Email belum diverifikasi, silahkan ketik "resend" untuk mengirim kembali');

             return response('forbidden' , 403);
        }
        
        return $next($request);
    }
}
