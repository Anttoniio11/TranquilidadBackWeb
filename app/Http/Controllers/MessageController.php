<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    // Mostrar todos los mensajes
    public function index(Request $request)
    {
        $messages = Message::query()
            ->included()
            ->filter()
            ->sort()
            ->getOrPaginate();
        
        return response()->json($messages);
    }

    // Mostrar un mensaje específico
    public function show($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($message);
    }

    // Crear un nuevo mensaje
    public function store(Request $request)
    {
        $request->validate([
            'fecha_hora' => 'required|date',
            'contenido' => 'required|string',
            'patient_id' => 'required|exists:patients,id',
            'chat_id' => 'required|exists:chats,id'
        ]);

        $message = Message::create($request->all());

        return response()->json($message, Response::HTTP_CREATED);
    }

    // Actualizar un mensaje existente
    public function update(Request $request, $id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'fecha_hora' => 'nullable|date',
            'contenido' => 'nullable|string',
            'patient_id' => 'nullable|exists:patients,id',
            'chat_id' => 'nullable|exists:chats,id'
        ]);

        $message->update($request->all());

        return response()->json($message);
    }

    // Eliminar un mensaje
    public function destroy($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], Response::HTTP_NOT_FOUND);
        }

        $message->delete();

        return response()->json(['message' => 'Message deleted successfully']);
    }
}
