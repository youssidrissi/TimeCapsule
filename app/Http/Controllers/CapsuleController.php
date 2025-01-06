<?php

namespace App\Http\Controllers;

use App\Models\Capsule;
use App\Models\Content;
use App\Models\CapsuleRecipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CapsuleController extends Controller
{
    public function isAdmin()
{
    return $this->role === 'admin';
}

public function index(Request $request)
{
    // Récupère toutes les capsules sans aucun filtre
    $capsules = Capsule::all();

    // Renvoie les capsules sous forme de réponse JSON
    return response()->json($capsules);
}


    // Affiche une capsule spécifique
    public function show($id)
    {
        $capsule = Capsule::with(['contents', 'recipients', 'user'])->findOrFail($id);
        return response()->json($capsule);
    }

    public function store(Request $request)
    {
        // Valide les données envoyées par la requête
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'required|boolean',
            'type' => 'required|in:temporelle,compte à rebours,auto-destructrice',
            'status' => 'required|in:En attente,Prête à ouvrir',
            'open_date' => 'nullable|date',
        ]);

        // Crée la capsule en associant l'utilisateur authentifié
        $capsule = Capsule::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'is_public' => $validated['is_public'],
            'type' => $validated['type'],
            'status' => $validated['status'],
            'open_date' => $validated['open_date'],
            'user_id' => Auth::id(), // Associe l'utilisateur authentifié
        ]);

        // Retourne une réponse avec la capsule créée
        return response()->json([
            'message' => 'Capsule créée avec succès',
            'capsule' => $capsule,
        ], 201);
    }
    
    
    // Met à jour une capsule
        public function update(Request $request, $id)
        {
            $capsule = Capsule::findOrFail($id);

            if ($capsule->user_id !== $request->user()->id) {
                return response()->json(['error' => 'Non autorisé'], 403);
            }

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'nullable|boolean',
            'status' => 'nullable|in:En attente,Prête à ouvrir',
            'open_date' => 'nullable|date',
        ]);

        $capsule->update($validated);

        return response()->json(['message' => 'Capsule mise à jour avec succès', 'capsule' => $capsule]);
    }

   
public function destroy($id)
{
    // Récupère la capsule par son ID
    $capsule = Capsule::findOrFail($id);

    // Vérifie si la capsule a expiré ou si la suppression a été demandée par un clic
    if (Carbon::now()->greaterThanOrEqualTo($capsule->end_date) || $this->isUserRequestToDelete()) {
        // Supprime la capsule
        $capsule->delete();

        // Retourne une réponse JSON selon le cas
        if (Carbon::now()->greaterThanOrEqualTo($capsule->end_date)) {
            return response()->json(['message' => 'Capsule supprimée automatiquement car sa date de fin est arrivée']);
        } else {
            return response()->json(['message' => 'Capsule supprimée manuellement']);
        }
    }

    // Si la capsule n'est pas expirée et l'utilisateur n'a pas demandé la suppression
    return response()->json(['message' => 'La capsule ne peut pas être supprimée']);
}

    // Vérifie si la suppression a été demandée par un clic (envoi d'une requête DELETE)
    private function isUserRequestToDelete()
    {
        // La suppression manuelle peut être déclenchée par un appel DELETE classique via un bouton ou une action utilisateur
        return request()->isMethod('delete');
    }
}