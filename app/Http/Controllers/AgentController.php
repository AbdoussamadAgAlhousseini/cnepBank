<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Agent;

class AgentController extends Controller
{

    public function showChangePasswordForm()
    {
        return view('agent.change_password');
    }


    public function changePassword(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);


        $agent = Auth::guard('agent')->user();


        if (!Hash::check($request->current_password, $agent->mot_de_passe)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $agent->mot_de_passe = Hash::make($request->new_password);
        $agent->save();

        return back()->with('success', 'Mot de passe mis à jour avec succès.');
    }
}
