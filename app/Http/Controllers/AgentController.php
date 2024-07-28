<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class AgentController extends Controller
{
    public function home()
    {
        $agent = Auth::guard('agent')->user();

        if (!$agent) {
            abort(404, 'Agent not found');
        }

        // Récupérer les transactions en les ordonnant par date de création
        $transactions = Transaction::where('agent_id', $agent->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $nombreTransactions = $transactions->count();
        $nombreRetraits = $transactions->where('type', 'retrait')->count();
        $nombreVersements = $transactions->where('type', 'versement')->count();
        $sommeRetraits = $transactions->where('type', 'retrait')->sum('montant');
        $sommeVersements = $transactions->where('type', 'versement')->sum('montant');

        // Ajouter les totaux manquants
        $totalRetraits = $sommeRetraits;
        $totalVersements = $sommeVersements;

        return view('agent.home', compact(
            'agent',
            'transactions',
            'nombreTransactions',
            'nombreRetraits',
            'nombreVersements',
            'sommeRetraits',
            'sommeVersements',
            'totalRetraits',
            'totalVersements'
        ));
    }
}
