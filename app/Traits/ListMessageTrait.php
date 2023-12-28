<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

trait ListMessageTrait
{
    public function listMessage()
    {
        $data = [
            //"token" => env('TOKEN_WA'),
            'phone' => env('TEST_PHONE'),
            "body" => "Please choose option",
            "action" => "List",
            "header" => 'Ini adalah pesan header',
            "footer" => 'Ya ini footer',
            "sections" => [
               
                [
                    "title" => "Dapatkan Data",
                    "rows" => [
                        [
                            "id" => "2",
                            "title" => "Cek Saldo",
                            "description" => "Dapatkan jumlah saldo saat ini"
                        ],
                        [
                            "id" => "3",
                            "title" => "Cek Transaksi Terakhir",
                            "description" => "Dapatkan informasi traksaksi terakhir"
                        ]
                    ]
                ]
            ]
        ];

        return $data;
    
    }


    public function message(string $data)
    {
        $data = [
            //"token" => env('TOKEN_WA'),
            'phone' => env('TEST_PHONE'),
            "body" => $data
        ];

        return $data;
    }



    public function registerNasabahForm()
    {
        $message = "Anda belum terdaftar, silahkan kirim pesan dengan mengikut format berikut.\n"
                    . "#nik#email#nama \n"
                    . "Pastikan data yang kamu kirim adalah data yang valid dan benar!. \n\n"
                    . "Terimakasih,\n"
                    . "Koperasi Hub";
        return $message;
    }


    public function listOption()
    {
         $option = "Pilih Opsi Berikut:\n\n"
                    . "1. Cek Saldo\n"
                    . "2. Cek Mutasi/History Transaksi\n"
                 ;

        return $option;
    }

    public function setMessageHistoryTransaction(array $data)
    {
        $message = "Berikut adalah riwayat transaksi anda:\n\n";

        foreach($data as $key => $value){
            $message .= "-Transaksi sebesar Rp " . $value['Amount'] + $value['Fee'] . ", channel pembayaran " . $value['PaymentChannel'] . "\n"
            . 'Untuk melihat lebih detail ketik "' . $key .  '"' . "\n\n";
        }

        return $message;
    }


    public function setDetailMessageTransaction(array $data)
    {
        Log::debug($data);
        $message = "Berikut adalah detail transaksi anda:\n\n"
                   . "-Transaksi sebesar Rp " . $data['Amount'] + $data['Fee'] . ", channel pembayaran " . $data['PaymentChannel'] . "\n"
                   . "Dibuat pada tanggal " . Carbon::parse($data['CreatedDate'])->format('d-M-Y H:i:s');
        
        return $message;
                   
        
    }
}

