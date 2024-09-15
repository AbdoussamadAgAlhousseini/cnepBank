<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Agence;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AgentManagementController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $agence = Agence::where('directeur_id', $user->id)->first();

        if (!$agence) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'avez pas d\'agence associée');
        }


        $agents = Agent::where('agence_id', $agence->id)->whereNull('deleted_at')->get();

        return view('directeur.agents.index', compact('agents'));
    }


    public function create()
    {
        return view('directeur.agents.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $agence = Agence::where('directeur_id', $user->id)->first();

        if (!$agence) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'avez pas d\'agence associée');
        }


        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:agents',
            'mot_de_passe' => 'required|string|min:8|confirmed',
        ]);


        $validatedData['agence_id'] = $agence->id;
        $validatedData['mot_de_passe'] = Hash::make($validatedData['mot_de_passe']);

        Agent::create($validatedData);

        return redirect()->route('directeur.agents.index')->with('success', 'Agent créé avec succès');
    }


    public function destroy(Agent $agent)
    {
        $user = Auth::user();
        $agence = Agence::where('directeur_id', $user->id)->first();

        if (!$agence) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'avez pas d\'agence associée');
        }


        if ($agent->agence_id == $agence->id) {
            $agent->delete();
            return redirect()->route('directeur.agents.index')->with('success', 'Agent supprimé avec succès');
        }

        return redirect()->route('directeur.agents.index')->with('error', 'Vous n\'êtes pas autorisé à supprimer cet agent');
    }


    public function showTransactions(Request $request, $agentId)
    {
        $user = Auth::user();
        $agence = Agence::where('directeur_id', $user->id)->first();

        if (!$agence) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'avez pas d\'agence associée');
        }

        $agent = Agent::withTrashed()->where('id', $agentId)->where('agence_id', $agence->id)->first();

        if (!$agent) {
            return redirect()->route('directeur.agents.index')->with('error', 'Agent non trouvé ou non autorisé');
        }


        $transactions = Transaction::where('agent_id', $agent->id)->get();


        $totalRetraits = $transactions->where('type', 'retrait')->sum('montant');
        $totalVersements = $transactions->where('type', 'versement')->sum('montant');
        $nombreRetraits = $transactions->where('type', 'retrait')->count();
        $nombreVersements = $transactions->where('type', 'versement')->count();


        return view('directeur.agents.transactions', compact('agent', 'transactions', 'totalRetraits', 'totalVersements', 'nombreRetraits', 'nombreVersements'));
    }
}
