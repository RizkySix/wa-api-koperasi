<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait RegexFormatTrait
{
    /**
     * Untuk mengambil data sesuai format misal, Nik: nik123
     * nik123 akan diambil
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
     */
    public function getValue(Request $request)
    {
        $fullMsg = $request->message;

        $data = [
            'phone' => $request->remote_id,
            'nik' => $this->extractValue($fullMsg, 'Nik:'),
            'name' => $this->extractValue($fullMsg, 'Nama:'),
            'email' => $this->extractValue($fullMsg, 'Email:'),
        ];

        return $data;
        
    }
    
}