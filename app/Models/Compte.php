<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    use HasFactory;


    // Dans le modèle Compte
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
