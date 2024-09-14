<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Agent;

class AgentController extends Controller
{
    // Affichage du formulaire pour changer le mot de passe
    public function showChangePasswordForm()
    {
        return view('agent.change_password');
    }

    // Méthode pour changer le mot de passe
    public function changePassword(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Récupérer l'agent connecté
        $agent = Auth::guard('agent')->user();

        // Vérifier que le mot de passe actuel correspond
        if (!Hash::check($request->current_password, $agent->mot_de_passe)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        // Mettre à jour le mot de passe
        $agent->mot_de_passe = Hash::make($request->new_password);
        $agent->save();

        return back()->with('success', 'Mot de passe mis à jour avec succès.');
    }
}
