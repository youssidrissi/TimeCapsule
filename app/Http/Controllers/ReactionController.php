<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    // Récupérer toutes les réactions
    public function index()
    {
        return response()->json(Reaction::with(['user', 'capsule'])->get());
    }

    // Afficher une réaction spécifique
    public function show($id)
    {
        $reaction = Reaction::with(['user', 'capsule'])->findOrFail($id);
        return response()->json($reaction);
    }

    // Créer une nouvelle réaction
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'capsule_id' => 'required|exists:capsules,id',
            'type' => 'required|in:like,comment',
            'comment_text' => 'nullable|string',
        ]);
        $validatedData['user_id'] = auth()->id();

        $reaction = Reaction::create($validatedData);
        return response()->json($reaction, 201);
    }

    // Mettre à jour une réaction existante (par exemple modifier un commentaire)
    public function update(Request $request, $id)
    {
        $reaction = Reaction::findOrFail($id);
        $validatedData = $request->validate([
            'type' => 'in:like,comment',
            'comment_text' => 'nullable|string',
        ]);

        $reaction->update($validatedData);
        return response()->json($reaction);
    }

    // Supprimer une réaction
    public function destroy($id)
    {
        Reaction::findOrFail($id)->delete();
        return response()->json(['message' => 'Réaction supprimée'], 204);
    }
}
