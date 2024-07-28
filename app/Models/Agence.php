<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'adresse',
        'solde',
        'directeur_id',
    ];

    public function directeur()
    {
        return $this->belongsTo(User::class, 'directeur_id');
    }

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
