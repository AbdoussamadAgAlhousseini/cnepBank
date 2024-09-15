<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class AgentDashboardController extends Controller
{
    public function show()
    {
        $agent = Auth::guard('agent')->user();

        if (!$agent) {
            abort(404, 'Agent not found');
        }


        $transactions = Transaction::where('agent_id', $agent->id)
            ->orderBy('created_at', 'desc')
            ->get();


        $retraits = $transactions->where('type', 'retrait');
        $versements = $transactions->where('type', 'versement');


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
