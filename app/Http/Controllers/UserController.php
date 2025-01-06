<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    // Récupérer tous les utilisateurs
    public function index()
    {
        return response()->json(User::all());
    }

    // Afficher un utilisateur spécifique
    public function show($id)
    {
        $user = User::with(['capsules', 'notifications', 'reactions'])->findOrFail($id);
        return response()->json($user);
    }

    // Créer un nouvel utilisateur
    public function store(Request $request)
    {
        try {
            // Récupérer toutes les données envoyées
            $data = $request->only(['name', 'email', 'password', 'profile_picture']);

            // Valider les données entrantes
            $validatedData = Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'profile_picture' => 'nullable|string', // Si la photo est optionnelle
            ])->validate();

            // Créer un utilisateur avec les données validées
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'profile_picture' => $validatedData['profile_picture'] ?? null, // Gère la valeur nulle
            ]);

            // Retourne une réponse JSON en cas de succès
            return response()->json([
                'message' => 'Utilisateur créé avec succès.',
                'data' => $user,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Retourne les erreurs de validation
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Gérer toute autre exception
            return response()->json([
                'message' => 'Une erreur est survenue.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    // Mettre à jour un utilisateur existant
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email', 'profile_picture'));
        return response()->json($user);
    }
    // Supprimer un utilisateur
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'Utilisateur supprimé avec succès'], 204);
    }

    // Récupérer les notifications d'un utilisateur
    public function notifications($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user->notifications);
    }
}
