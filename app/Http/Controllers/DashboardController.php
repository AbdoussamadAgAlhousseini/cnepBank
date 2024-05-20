<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $agence_id = $request->get('agence_id');

        // Récupérer toutes les agences avec le nombre de transactions
        $agences = Agence::withCount('transactions')->get();

        // Récupérer les transactions en fonction de l'agence sélectionnée
        $transactions = Transaction::with('agent', 'agence')
            ->when($agence_id, function ($query, $agence_id) {
                return $query->where('agence_id', $agence_id);
            })
            ->latest()
            ->take(20)
            ->get();

        // Préparer les données pour le graphique
        $labels = [];
        $data = [];
        foreach ($agences as $agence) {
            $labels[] = $agence->nom;
            $data[] = $agence->transactions_count;
        }

        return view('dashboards', [
            'agences' => $agences,
            'transactions' => $transactions,
            'labels' => $labels,
            'data' => $data,
        ]);
    }



    public function dashboard(Request $request)
    {
        // Récupérer les filtres
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $transactionType = $request->input('transaction_type');
        $agenceId = $request->input('agence_id');

        // Filtrer les transactions en fonction des filtres appliqués
        $query = Transaction::query();

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($transactionType) {
            $query->where('type', $transactionType);
        }

        if ($agenceId) {
            $query->where('agence_id', $agenceId);
        }

        $transactions = $query->get();

        // Récupérer les données pour les graphiques
        $chartData = $this->getChartData($transactions);
        $monthlyChartData = $this->getMonthlyChartData($transactions);

        $agences = Agence::all();

        return view('dashboard', compact('transactions', 'agences', 'chartData', 'monthlyChartData'));
    }

    private function getChartData($transactions)
    {
        $agences = Agence::all();
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
