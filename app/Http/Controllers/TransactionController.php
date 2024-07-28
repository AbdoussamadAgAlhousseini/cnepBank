<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        return view('agent.home');
    }

    // public function create()
    // {
    //     return view('agent.transactions.create');

    // }



    public function create()
    {
        $comptes = Auth::guard('agent')->user()->agence->comptes;
        return view('agent.transactions.create', compact('comptes'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric',
            'type' => 'required|in:versement,retrait',
            'compte_id' => 'nullable|exists:comptes,id', // Allow 'compte_id' to be nullable
        ]);

        $transaction = new Transaction();
        $transaction->agent_id = Auth::guard('agent')->id();
        $transaction->agence_id = Auth::guard('agent')->user()->agence_id;

        $montant = $request->input('montant');
        $type = $request->input('type');

        // If the transaction type is 'retrait', make the amount negative
        if ($type == 'retrait' && $montant > 0) {
            $montant = -$montant;
        }

        $transaction->montant = $montant;
        $transaction->type = $type;
        $transaction->compte_id = $request->input('compte_id'); // 'compte_id' can be null
        $transaction->save();

        return redirect()->route('agent.home')->with('success', 'Transaction ajoutée avec succès.');
    }
}
