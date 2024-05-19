<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    // Dans le modèle Agent
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
