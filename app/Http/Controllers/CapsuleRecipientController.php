<?php

namespace App\Http\Controllers;

use App\Models\CapsuleRecipient;
use Illuminate\Http\Request;

class CapsuleRecipientController extends Controller
{
    // Liste les destinataires d'une capsule
    public function index($capsuleId)
    {
        $recipients = CapsuleRecipient::where('capsule_id', $capsuleId)->with('user')->get();
        return response()->json($recipients);
    }

    // Ajoute un destinataire à une capsule
    public function store(Request $request, $capsuleId)
{
    // Valider uniquement user_id puisque capsule_id est déjà dans l'URL
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    // Créer un destinataire avec capsule_id provenant de l'URL et user_id validé
    $recipient = CapsuleRecipient::create([
        'capsule_id' => $capsuleId,
        'user_id' => $validated['user_id'],
    ]);

    return response()->json(['message' => 'Destinataire ajouté avec succès', 'recipient' => $recipient]);
}

    // Supprime un destinataire d'une capsule
    public function destroy($id)
    {
        $recipient = CapsuleRecipient::findOrFail($id);
        $recipient->delete();

        return response()->json(['message' => 'Destinataire supprimé avec succès']);
    }
}