<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralWallet extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * Belogsto user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
