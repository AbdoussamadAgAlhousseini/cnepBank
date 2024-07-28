<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Transaction extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'montant',
        'agent_id',
        'agence_id', // Clé étrangère
        'created_at',
    ];

    // public function agent()
    // {
    //     return $this->belongsTo(Agent::class);
    // }


    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }


    // public function agence()
    // {
    //     return $this->belongsTo(Agence::class);
    // }




    public function agent()
    {
        return $this->belongsTo(Agent::class)->withTrashed();
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }
}
