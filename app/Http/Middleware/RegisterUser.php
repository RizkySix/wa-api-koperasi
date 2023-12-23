<?php

namespace App\Http\Middleware;

use App\Contract\Services\UserServiceInterface;
use App\Contract\Services\WhatsappBotServiceInterface;
use App\Helper\AuthorizationWaApi;
use App\Helper\HelperMethod;
use App\Traits\AuthenticationTrait;
use App\Traits\ListMessageTrait;
use App\Traits\RegexFormatTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterUser
{
    use RegexFormatTrait, ListMessageTrait, AuthenticationTrait;
    private $userServiceInterface;
    private $whatsappBotServiceInterface;

    public function __construct(UserServiceInterface $userServiceInterface, WhatsappBotServiceInterface $whatsappBotServiceInterface)
    {
        $this->userServiceInterface = $userServiceInterface;
        $this->whatsappBotServiceInterface = $whatsappBotServiceInterface;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        $receiverPhone = HelperMethod::phoneUserFormat($request->remote_id);
        $payload = $this->getValue($request);

        $findUser = $this->userServiceInterface->findUserByPhone($receiverPhone);
        $findKoperasiBot = $this->whatsappBotServiceInterface->findBotByBotPhone($payload['bot_phone']);
       
        $request->attributes->add(['user' => $findUser]);
        $request->attributes->add(['koperasi_bot' => $findKoperasiBot]);
        $request->attributes->add(['payload' => $payload]);

        if(isset($payload['status'])){
            AuthorizationWaApi::seeBotSendMessage($findKoperasiBot->app_key , $receiverPhone, 'Data yang anda kirim tidak valid');

            return response('invalid content or data' , 422);
        }

        if(!$findUser && ($payload['nik'] == null || $payload['name'] == null || $payload['email'] == null)){
            AuthorizationWaApi::seeBotSendMessage($findKoperasiBot->app_key , $receiverPhone , $this->registerNasabahForm());

            return response('register format sent' , 200);
        }

        return $next($request);
    }
}
