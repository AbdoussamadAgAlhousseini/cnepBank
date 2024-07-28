<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'agence_id',
        'created_at',
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // public function setMotDePasseAttribute($value)
    // {
    //     $this->attributes['mot_de_passe'] = bcrypt($value);
    // }

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
}
