<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgenceController extends Controller
{
    public function create()
    {

        $agences = Agence::with('directeur')->get();
        return view('directeur_general.agences.create', compact('agences'));
        // return view('directeur_general.agences.create');
    }

    public function store(Request $request)
    {
        // Valider les champs de formulaire sauf le mot de passe
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'solde' => 'required|numeric|min:0',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users', // Vérification d'unicité de l'email pour les directeurs
        ]);

        // Définir le mot de passe par défaut
        $defaultPassword = 'password';

        try {
            // Créer le directeur
            $directeur = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($defaultPassword),
                'role' => 'directeur',
            ]);

            // Créer l'agence
            $agence = Agence::create([
                'nom' => $request->nom,
                'adresse' => $request->adresse,
                'solde' => $request->solde,  // Utilisez le nom de colonne correct
                'directeur_id' => $directeur->id,
            ]);

            return redirect()->route('dashboard')->with('success', 'Agence créée avec succès');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }








    public function createDirecteur($id)
    {
        $agence = Agence::findOrFail($id);
        return view('directeur_general.agences.create-directeur', compact('agence'));
    }

    public function storeDirecteur(Request $request, $agenceId)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Logique de création du directeur pour l'agence
        $directeur = new User();
        $directeur->name = $validatedData['name'];
        $directeur->email = $validatedData['email'];
        $directeur->password = Hash::make($validatedData['password']);
        $directeur->role = 'directeur'; // ou tout autre rôle selon votre système
        $directeur->save();

        // Logique pour l'association avec l'agence
        $agence = Agence::findOrFail($agenceId);
        $agence->directeur_id = $directeur->id;
        $agence->save();

        return redirect()->route('agences.index')->with('success', 'Directeur créé avec succès pour l\'agence.');
    }


    public function editDirecteur($id)
    {
        $agence = Agence::findOrFail($id);
        $directeurs = User::where('role', 'directeur')->get();
        return view('directeur_general.agences.edit-directeur', compact('agence', 'directeurs'));
    }

    public function updateDirecteur(Request $request, $id)
    {
        $request->validate([
            'directeur_id' => 'required|exists:users,id',
        ]);

        $agence = Agence::findOrFail($id);
        $agence->directeur_id = $request->directeur_id;
        $agence->save();

        return redirect()->route('directeur_general.create')->with('success', 'Directeur updated successfully');
    }
}
