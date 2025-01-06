<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    // Liste le contenu d'une capsule
    public function index($capsuleId)
    {
        $contents = Content::where('capsule_id', $capsuleId)->get();
        return response()->json($contents);
    }

    // Ajoute du contenu à une capsule
    public function store(Request $request)
    {
        $validated = $request->validate([
            'capsule_id' => 'required|exists:capsules,id',
            'type' => 'required|in:text,image,video,audio',
            'file_path' => 'nullable|string',
            'text_content' => 'nullable|string',
        ]);

        $content = Content::create($validated);

        return response()->json(['message' => 'Contenu ajouté avec succès', 'content' => $content]);
    }

        // Met à jour un contenu existant
        public function update(Request $request, $id)
        {
            $content = Content::findOrFail($id);

            $validated = $request->validate([
                'type' => 'nullable|in:text,image,video,audio',
                'file_path' => 'nullable|string',
                'text_content' => 'nullable|string',
            ]);

            $content->update($validated);

            return response()->json(['message' => 'Contenu mis à jour avec succès', 'content' => $content]);
        }

        // Supprime un contenu
        public function destroy($id)
        {
            $content = Content::findOrFail($id);
            $content->delete();

            return response()->json(['message' => 'Contenu supprimé avec succès']);
        }
}