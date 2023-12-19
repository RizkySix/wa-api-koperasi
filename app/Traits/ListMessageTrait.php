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
        $message = "Anda belum terdaftar silahkan lengkapi form berikut dan kirim kembali.\n\n"
                    . "Nik: \n"
                    . "Nama: \n"
                    . "Email: \n\n"
                    . "Terimakasih,\n"
                    . "Koperasi Hub";
        return $message;
    }
}

