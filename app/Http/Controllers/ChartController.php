<?php



namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    // public function barChart(Request $request)
    // {
    //     $agence_id = $request->get('agence_id');

    //     // Récupérer toutes les agences avec le nombre de transactions
    //     $agences = Agence::withCount('transactions')->get();

    //     // Récupérer les transactions en fonction de l'agence sélectionnée
    //     $transactions = Transaction::with('agent', 'agence')
    //         ->when($agence_id, function ($query, $agence_id) {
    //             return $query->where('agence_id', $agence_id);
    //         })
    //         ->latest()
    //         ->take(20)
    //         ->get();

    //     // Préparer les données pour le graphique
    //     $labels = [];
    //     $data = [];
    //     foreach ($agences as $agence) {
    //         $labels[] = $agence->nom;
    //         $data[] = $agence->transactions_count;
    //     }

    //     return view('bar-chart', [
    //         'agences' => $agences,
    //         'transactions' => $transactions,
    //         'labels' => $labels,
    //         'data' => $data,
    //     ]);
    // }




    public function dashboard(Request $request)
    {
        $agenceId = $request->input('agence_id');

        // Fetch agencies for the filter form
        $agences = Agence::all();

        // Fetch transactions based on the selected agency (or all transactions if no agency is selected)
        if ($agenceId) {
            $transactions = Transaction::where('agence_id', $agenceId)->with('agent')->latest()->take(20)->get();
        } else {
            $transactions = Transaction::with('agent')->latest()->take(20)->get();
        }

        // Prepare data for the chart (transactions by agency)
        $transactionCounts = Transaction::selectRaw('count(*) as count, agence_id')
            ->groupBy('agence_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->agence_id => $item->count];
            });

        $labels = $agences->pluck('nom');
        $data = $agences->map(function ($agence) use ($transactionCounts) {
            return $transactionCounts[$agence->id] ?? 0;
        });

        $chartData = [
            'labels' => $labels,
            'data' => $data
        ];

        // Prepare data for transactions per month
        $transactionsPerMonth = Transaction::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [\DateTime::createFromFormat('!m', $item->month)->format('F') => $item->count];
            });

        $monthlyLabels = $transactionsPerMonth->keys();
        $monthlyData = $transactionsPerMonth->values();

        $monthlyChartData = [
            'labels' => $monthlyLabels,
            'data' => $monthlyData
        ];

        return view('bar-chart', compact('agences', 'transactions', 'chartData', 'monthlyChartData'));
    }
}
