<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use App\Models\Agent;



class AgentDashboardController extends Controller
{
    public function index()
    {
        return view('agent.dashboard');
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'montant' => 'required|numeric',

        ]);

        $transaction = new Transaction([
            'type' => $request->type,
            'montant' => $request->montant,
            'agent_id' => Auth::id(),
            'agence_id' => Auth::user()->agence_id,
        ]);

        $transaction->save();

        return back()->with('success', 'Transaction ajoutée avec succès!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:agents',
            'mot_de_passe' => 'required|string|min:8|confirmed',
        ]);

        $agent = Agent::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'agence_id' => $request->agence_id,
            'mot_de_passe' => Hash::make($request->mot_de_passe), // Hash the password
        ]);

        // Redirect or return response as needed
    }
}
