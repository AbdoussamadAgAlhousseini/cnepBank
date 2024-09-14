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
    // Afficher la liste des agents associés à l'agence du directeur
    public function index()
    {
        $user = Auth::user();
        $agence = Agence::where('directeur_id', $user->id)->first();

        if (!$agence) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'avez pas d\'agence associée');
        }

        // Récupérer les agents de l'agence, excepté ceux qui sont supprimés (soft delete)
        $agents = Agent::where('agence_id', $agence->id)->whereNull('deleted_at')->get();

        return view('directeur.agents.index', compact('agents'));
    }

    // Afficher le formulaire pour ajouter un nouvel agent
    public function create()
    {
        return view('directeur.agents.create');
    }

    // Enregistrer un nouvel agent dans la base de données
    public function store(Request $request)
    {
        $user = Auth::user();
        $agence = Agence::where('directeur_id', $user->id)->first();

        if (!$agence) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'avez pas d\'agence associée');
        }

        // Validation des données du formulaire
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:agents',
            'mot_de_passe' => 'required|string|min:8|confirmed',
        ]);

        // Associer l'agent à l'agence du directeur et hasher le mot de passe
        $validatedData['agence_id'] = $agence->id;
        $validatedData['mot_de_passe'] = Hash::make($validatedData['mot_de_passe']);

        // Créer l'agent
        Agent::create($validatedData);

        return redirect()->route('directeur.agents.index')->with('success', 'Agent créé avec succès');
    }

    // Supprimer un agent de manière sécurisée (soft delete)
    public function destroy(Agent $agent)
    {
        $user = Auth::user();
        $agence = Agence::where('directeur_id', $user->id)->first();

        if (!$agence) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'avez pas d\'agence associée');
        }

        // Vérifier si l'agent appartient à l'agence du directeur
        if ($agent->agence_id == $agence->id) {
            $agent->delete();
            return redirect()->route('directeur.agents.index')->with('success', 'Agent supprimé avec succès');
        }

        return redirect()->route('directeur.agents.index')->with('error', 'Vous n\'êtes pas autorisé à supprimer cet agent');
    }

    // Afficher les transactions d'un agent spécifique
    public function showTransactions(Request $request, $agentId)
    {
        $user = Auth::user();
        $agence = Agence::where('directeur_id', $user->id)->first();

        if (!$agence) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'avez pas d\'agence associée');
        }

        // Récupérer l'agent, y compris ceux supprimés (soft delete)
        $agent = Agent::withTrashed()->where('id', $agentId)->where('agence_id', $agence->id)->first();

        if (!$agent) {
            return redirect()->route('directeur.agents.index')->with('error', 'Agent non trouvé ou non autorisé');
        }

        // Récupérer les transactions de l'agent
        $transactions = Transaction::where('agent_id', $agent->id)->get();

        // Calculer les totaux et les compteurs pour les retraits et versements
        $totalRetraits = $transactions->where('type', 'retrait')->sum('montant');
        $totalVersements = $transactions->where('type', 'versement')->sum('montant');
        $nombreRetraits = $transactions->where('type', 'retrait')->count();
        $nombreVersements = $transactions->where('type', 'versement')->count();

        // Retourner la vue avec les données
        return view('directeur.agents.transactions', compact('agent', 'transactions', 'totalRetraits', 'totalVersements', 'nombreRetraits', 'nombreVersements'));
    }
}
