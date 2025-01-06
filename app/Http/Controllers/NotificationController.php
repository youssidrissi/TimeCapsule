<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Récupérer toutes les notifications
    public function index()
    {
        return response()->json(Notification::all());
    }

    // Afficher une notification spécifique
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        return response()->json($notification);
    }

    // Créer une nouvelle notification
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'message' => 'required|string',
            'related_capsule_id' => 'nullable|exists:capsules,id',
        ]);
        $validatedData['user_id'] = auth()->id();

        $notification = Notification::create($validatedData);
        return response()->json($notification, 201);
    }

    // Mettre à jour une notification (ex : marquer comme lue)
    public function update(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update($request->only('is_read'));
        return response()->json($notification);
    }

    // Supprimer une notification
    public function destroy($id)
    {
        Notification::findOrFail($id)->delete();
        return response()->json(['message' => 'Notification supprimée'], 204);
    }
}
