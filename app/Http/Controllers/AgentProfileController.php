<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AgentProfileController extends Controller
{
    public function editPassword()
    {
        return view('agent.edit-password');
    }

    public function updatePassword(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $agent = Auth::guard('agent')->user();

        if (!Hash::check($request->current_password, $agent->mot_de_passe)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect']);
        }

        $agent->mot_de_passe = Hash::make($request->new_password);

        // Ajoutez cette ligne pour vérifier les données de l'agent avant de les sauvegarder
        dd($agent);

        $agent->save();

        return redirect()->route('agent.home')->with('success', 'Le mot de passe a été mis à jour avec succès');
    }
}
