<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    // Mostrar todos los chats
    public function index(Request $request)
    {
        $chats = Chat::query()
            ->included()
            ->filter()
            ->sort()
            ->getOrPaginate();
        
        return response()->json($chats);
    }

    // Mostrar un chat específico
    public function show($id)
    {
        $chat = Chat::find($id);

        if (!$chat) {
            return response()->json(['message' => 'Chat not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($chat);
    }

    // Crear un nuevo chat
    public function store(Request $request)
    {
        $request->validate([
            'canal' => 'required|string',
            'descripcion' => 'nullable|string'
        ]);

        $chat = Chat::create($request->all());

        return response()->json($chat, Response::HTTP_CREATED);
    }

    // Actualizar un chat existente
    public function update(Request $request, $id)
    {
        $chat = Chat::find($id);

        if (!$chat) {
            return response()->json(['message' => 'Chat not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'canal' => 'nullable|string',
            'descripcion' => 'nullable|string'
        ]);

        $chat->update($request->all());

        return response()->json($chat);
    }

    // Eliminar un chat
    public function destroy($id)
    {
        $chat = Chat::find($id);

        if (!$chat) {
            return response()->json(['message' => 'Chat not found'], Response::HTTP_NOT_FOUND);
        }

        $chat->delete();

        return response()->json(['message' => 'Chat deleted successfully']);
    }
}
