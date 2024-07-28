<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $agence_id = $request->get('agence_id');

        // Filtrer les agences et transactions en fonction du rôle de l'utilisateur
        if ($user->role == 'directeur') {
            $agences = Agence::withCount('transactions')
                ->where('directeur_id', $user->id)
                ->get();
        } else {
            $agences = Agence::withCount('transactions')->get();
        }

        // Filtrer les transactions en fonction de l'agence sélectionnée
        $transactionsQuery = Transaction::with(['agent' => function ($query) {
            $query->withTrashed(); // Inclure les agents supprimés
        }, 'agence'])
            ->when($agence_id, function ($query, $agence_id) {
                return $query->where('agence_id', $agence_id);
            })
            ->when($user->role == 'directeur', function ($query) use ($user) {
                return $query->whereHas('agence', function ($q) use ($user) {
                    $q->where('directeur_id', $user->id);
                });
            });

        $transactions = $transactionsQuery->get();

        // Filtrer les transactions pour afficher les 20 dernières par ordre décroissant
        $recentTransactions = $transactionsQuery->latest()->take(20)->get();

        // Calcul des montants et des statistiques
        $totalRetraits = $transactions->where('type', 'retrait')->sum('montant');
        $totalVersements = $transactions->where('type', 'versement')->sum('montant');
        $nombreRetraits = $transactions->where('type', 'retrait')->count();
        $nombreVersements = $transactions->where('type', 'versement')->count();
        $solde = $agences->sum('solde'); // Le solde est maintenant récupéré directement à partir des agences
        $ratioRetraitsVersements = $totalVersements > 0 ? $totalRetraits / $totalVersements : 0;
        $moyenneRetraits = $nombreRetraits > 0 ? $totalRetraits / $nombreRetraits : 0;
        $moyenneVersements = $nombreVersements > 0 ? $totalVersements / $nombreVersements : 0;

        // Préparer les données pour le graphique
        $labels = [];
        $data = [];
        foreach ($agences as $agence) {
            $labels[] = $agence->nom;
            $data[] = $transactions->where('agence_id', $agence->id)->count();
        }

        return view('dashboards', [
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
        ]);
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // Récupérer les filtres
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $transactionType = $request->input('transaction_type');
        $agenceId = $request->input('agence_id');

        // Filtrer les transactions en fonction des filtres appliqués
        $query = Transaction::with(['agent' => function ($query) {
            $query->withTrashed(); // Inclure les agents supprimés
        }])
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('created_at', '<=', $endDate);
            })
            ->when($transactionType, function ($query, $transactionType) {
                return $query->where('type', $transactionType);
            })
            ->when($agenceId, function ($query, $agenceId) {
                return $query->where('agence_id', $agenceId);
            })
            ->when($user->role == 'directeur', function ($query) use ($user) {
                return $query->whereHas('agence', function ($q) use ($user) {
                    $q->where('directeur_id', $user->id);
                });
            });

        $transactions = $query->get();

        // Filtrer les transactions pour afficher les 20 dernières par ordre décroissant
        $recentTransactions = $query->latest()->take(20)->get();

        // Récupérer les données pour les graphiques
        $chartData = $this->getChartData($transactions);
        $monthlyChartData = $this->getMonthlyChartData($transactions);

        $agences = $user->role == 'directeur' ? Agence::where('directeur_id', $user->id)->get() : Agence::all();

        return view('dashboard', compact('transactions', 'recentTransactions', 'agences', 'chartData', 'monthlyChartData'));
    }

    private function getChartData($transactions)
    {
        $user = Auth::user();
        $agences = $user->role == 'directeur' ? Agence::where('directeur_id', $user->id)->get() : Agence::all();
        $data = [];
        $labels = [];

        foreach ($agences as $agence) {
            $labels[] = $agence->nom;
            $data[] = $transactions->where('agence_id', $agence->id)->count();
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getMonthlyChartData($transactions)
    {
        $monthlyData = $transactions->groupBy(function ($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('Y-m'); // grouper par année et mois
        })->map(function ($row) {
            return $row->count();
        });

        $labels = [];
        $data = [];
        $months = [
            "01" => "Jan",
            "02" => "Fev",
            "03" => "Mar",
            "04" => "Avr",
            "05" => "Mai",
            "06" => "Jui",
            "07" => "Jul",
            "08" => "Août",
            "09" => "Sept",
            "10" => "Oct",
            "11" => "Nov",
            "12" => "Dec",
        ];

        foreach ($monthlyData as $month => $count) {
            $year = substr($month, 0, 4);
            $month = substr($month, 5, 2);
            $labels[] = $months[$month] . " " . $year;
            $data[] = $count;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}
