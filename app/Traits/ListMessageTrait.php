<?php

namespace App\Traits;

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
}

