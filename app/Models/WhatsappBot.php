<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappBot extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * Relasi belongs to koperasi
     */
    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class);
    }
}
