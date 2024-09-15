<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Agence;
use App\Models\User;

class GeneralManagerController extends Controller
{
    public function createAgencyForm()
    {
        return view('general_manager.create-agency');
    }

    public function storeAgency(Request $request)
    {
        $request->validate([
            'agency_name' => 'required|string|max:255',
            'agency_address' => 'required|string|max:255',
            'agency_balance' => 'required|numeric|min:0',
            'director_name' => 'required|string|max:255',
            'director_email' => 'required|string|email|max:255|unique:users',
            'director_password' => 'required|string|min:8',
        ]);


        $directeur = User::create([
            'name' => $request->director_name,
            'email' => $request->director_email,
            'password' => Hash::make($request->director_password),
            'role' => 'directeur',
        ]);


        Agence::create([
            'nom' => $request->agency_name,
            'adresse' => $request->agency_address,
            'solde' => $request->agency_balance,
            'directeur_id' => $directeur->id,
        ]);

        return redirect()->route('general_manager.agencies.create')->with('success', 'Agence et Directeur créés avec succès');
    }
}
