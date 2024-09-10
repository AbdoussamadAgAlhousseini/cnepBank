<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class AgentDashboardController extends Controller
{
    public function show()
    {
        $agent = Auth::guard('agent')->user();

        // Vérification que l'agent est authentifié
        if (!$agent) {
            abort(404, 'Agent not found');
        }

        // Récupération des transactions de l'agent
        $transactions = Transaction::where('agent_id', $agent->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Filtrer les retraits et versements
        $retraits = $transactions->where('type', 'retrait');
        $versements = $transactions->where('type', 'versement');

        // Calcul des statistiques
        $nombreTransactions = $transactions->count();
        $sommeTransactions = $transactions->sum('montant');
        $nombreRetraits = $retraits->count();
        $nombreVersements = $versements->count();
        $sommeRetraits = $retraits->sum('montant');
        $sommeVersements = $versements->sum('montant');

        return view('agent.dashboard', compact(
            'agent',
            'transactions',
            'retraits',
            'versements',
            'nombreTransactions',
            'sommeTransactions',
            'nombreRetraits',
            'nombreVersements',
            'sommeRetraits',
            'sommeVersements'
        ));
    }
}
