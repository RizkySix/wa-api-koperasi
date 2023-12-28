<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

trait RegexFormatTrait
{
    /**
     * Untuk mengambil data sesuai format misal, Nik: nik123
     * nik123 akan diambil,
     * belum digunakan saat ini
     */
    public function extractValue($text, $field)
    {
        preg_match('/' . $field . '(.*?)\R/', $text, $matches);

        if (isset($matches[1])) {
            return trim($matches[1]);
        }
    
        return null;
    }
    

    /**
     * Untuk mengambil nik,email,name
     * 0 = nik , 1 = email , 2 = name
     */
    public function getValue(Request $request)
    {
        //$fullMsg = $request->message;

        // $data = [
        //     'phone' => $request->remote_id,
        //     'nik' => $this->extractValue($fullMsg, 'Nik:'),
        //     'name' => $this->extractValue($fullMsg, 'Nama:'),
        //     'email' => $this->extractValue($fullMsg, 'Email:'),
        //     'bot_phone' => $request->bot_phone
        // ];

        $getData = trim($request->message , '#');
        $getData = explode('#' , $getData);
       Log::debug($getData);

        if(isset($getData[0]) && isset($getData[1]) && isset($getData[2])){
            $validator = Validator::make([
                'nik' => $getData[0],
                'email' => $getData[1]
            ], [
                'nik' => 'digits:16|unique:users',
                'email' => 'email:dns|unique:users'
            ]);
    
            if($validator->fails()){
                Log::debug($validator->messages());
                return [
                    'status' => false,
                    'bot_phone' => $request->bot_phone
                ];
            }
        }

        $data = [
            'phone' => $request->remote_id,
            'nik' => $getData[0] ?? null,
            'email' => $getData[1] ?? null,
            'name' => $getData[2] ?? null,
            'bot_phone' => $request->bot_phone
        ];

        return $data;
        
    }
    

    /**
     * Set cache for list history transaction for 1 hour
     */
    public function cacheHistoryTransaction(array $data, User $user)
    {
        Cache::remember('history-general-transaction-' . $user->email , 60*60 , function(){
            return null;
        });

        Cache::put('history-general-transaction-' . $user->email, $data , 60*60);
    }
}