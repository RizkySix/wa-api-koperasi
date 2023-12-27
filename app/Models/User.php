<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



     /**
     * Relation many to many
     */
    public function koperasies()
    {
        return $this->belongsToMany(Koperasi::class , 'koperasi_user' , 'user_nik' , 'koperasi_id')
                ->withPivot('verified')
                ->withPivot('verified_at');
    }


    /**
     * Relasi hasone user
     */
    public function generalWallet()
    {
        return $this->hasOne(GeneralWallet::class);
    }

}
