<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koperasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relasi many to many
     */
    public function users()
    {
        return $this->belongsToMany(User::class , 'koperasi_user', 'koperasi_id' , 'user_nik')
                        ->withPivot('verified')
                        ->withPivot('verified_at');
    }


    /**
     * Relasi has one bot
     */
    public function bot()
    {
        return $this->hasOne(WhatsappBot::class);
    }
}
