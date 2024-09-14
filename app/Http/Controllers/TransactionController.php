<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Compte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function create()
    {
        // Récupérer tous les comptes disponibles
        $comptes = Compte::all();
        return view('agent.transactions.create', compact('comptes'));
    }

    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'montant' => 'required|numeric',
            'type' => 'required|in:versement,retrait',
            'compte_id' => 'required|exists:comptes,id',
        ]);

        // Récupérer le compte sélectionné
        $compte = Compte::find($request->input('compte_id'));

        // Vérification du retrait
        $montant = $request->input('montant');
        $type = $request->input('type');

        // Si c'est un retrait et le montant est supérieur au solde, on renvoie une erreur
        if ($type == 'retrait' && $montant > $compte->solde) {
            return redirect()->back()->withErrors(['error' => 'Le montant du retrait dépasse le solde disponible.']);
        }

        // Si c'est un retrait, rendre le montant négatif
        if ($type == 'retrait' && $montant > 0) {
            $montant = -$montant;
        }

        // Création de la transaction


        $transaction = new Transaction();
        $transaction->agent_id = Auth::guard('agent')->id(); // L'agent connecté
        $transaction->agence_id = Auth::guard('agent')->user()->agence_id; // L'agence de l'agent connecté
        $transaction->montant = $montant;
        $transaction->type = $type;
        $transaction->compte_id = $compte->id;


        // Sauvegarde de la transaction
        $transaction->save();

        // Mise à jour du solde du compte
        $compte->solde += $montant; // Le montant est déjà négatif si c'est un retrait
        $compte->save();

        return redirect()->route('agent.dashboard')->with('success', 'Transaction ajoutée avec succès.');
    }
}
