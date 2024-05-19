<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    use HasFactory;

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }


    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }


    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }
}
