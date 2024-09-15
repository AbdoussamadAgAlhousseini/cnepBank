<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $agence_id = $request->get('agence_id');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');


        $agences = $user->role == 'directeur'
            ? Agence::where('directeur_id', $user->id)->get()
            : Agence::all();

        $transactionsQuery = Transaction::with('agent', 'agence')
            ->when($agence_id, function ($query, $agence_id) {
                return $query->where('agence_id', $agence_id);
            })
            ->when($user->role == 'directeur', function ($query) use ($user) {
                return $query->whereHas('agence', function ($q) use ($user) {
                    $q->where('directeur_id', $user->id);
                });
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('created_at', '<=', $endDate);
            });

        $transactions = $transactionsQuery->get();


        $recentTransactions = $transactionsQuery->orderBy('created_at', 'desc')->take(20)->get();

        $totalRetraits = $transactions->where('type', 'retrait')->sum('montant');
        $totalVersements = $transactions->where('type', 'versement')->sum('montant');
        $nombreRetraits = $transactions->where('type', 'retrait')->count();
        $nombreVersements = $transactions->where('type', 'versement')->count();
        $solde = $agences->sum('solde');
        $ratioRetraitsVersements = $totalVersements > 0 ? $totalRetraits / $totalVersements : 0;
        $moyenneRetraits = $nombreRetraits > 0 ? $totalRetraits / $nombreRetraits : 0;
        $moyenneVersements = $nombreVersements > 0 ? $totalVersements / $nombreVersements : 0;


        $totalTransactions = $nombreRetraits + $nombreVersements;
        $pourcentageRetraits = $totalTransactions > 0 ? ($nombreRetraits / $totalTransactions) * 100 : 0;
        $pourcentageVersements = $totalTransactions > 0 ? ($nombreVersements / $totalTransactions) * 100 : 0;


        $agents = $transactions->groupBy('agent_id');
        $agentNames = [];
        $transactionCounts = [];

        foreach ($agents as $agentId => $agentTransactions) {
            $agent = $agentTransactions->first()->agent;
            $agentNames[] = $agent ? $agent->nom : 'Agent supprimé';
            $transactionCounts[] = $agentTransactions->count();
        }


        $labels = [];
        $data = [];
        foreach ($agences as $agence) {
            $labels[] = $agence->nom;
            $data[] = $transactions->where('agence_id', $agence->id)->count();
        }

        $camembertData = [
            'labels' => ['Retraits', 'Versements'],
            'datasets' => [
                [
                    'data' => [$pourcentageRetraits, $pourcentageVersements],
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB']
                ]
            ]
        ];

        return view('dashboard1', [
            'agences' => $agences,
            'transactions' => $recentTransactions,
            'labels' => $labels,
            'data' => $data,
            'totalRetraits' => $totalRetraits,
            'totalVersements' => $totalVersements,
            'nombreRetraits' => $nombreRetraits,
            'nombreVersements' => $nombreVersements,
            'solde' => $solde,
            'ratioRetraitsVersements' => $ratioRetraitsVersements,
            'moyenneRetraits' => $moyenneRetraits,
            'moyenneVersements' => $moyenneVersements,
            'camembertData' => $camembertData,
            'agentNames' => $agentNames,
            'transactionCounts' => $transactionCounts,
        ]);
    }
}
