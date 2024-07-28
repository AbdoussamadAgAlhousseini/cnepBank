<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_compte',
        'solde',
        'proprietaire_id', // Clé étrangère
        'created_at',
    ];


    // Dans le modèle Compte
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
