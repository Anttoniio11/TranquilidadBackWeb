<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForumController extends Controller
{
    // Mostrar todos
    public function index(Request $request)
    {
        $forums = Forum::included()->filter()->sort()->getOrPaginate();
        return response()->json($forums);
    }

    // Mostrar uno
    public function show($id)
    {
        $forum = Forum::included()->find($id);

        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($forum);
    }

    // Crear
    public function store(Request $request)
    {
        $request->validate([
            'resourceType' => 'required|string',
            'content' => 'required|string',
            'publicationDate' => 'required|date',
        ]);

        $forum = Forum::create($request->all());

        return response()->json($forum, Response::HTTP_CREATED);
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'resourceType' => 'string',
            'content' => 'string',
            'publicationDate' => 'date',
        ]);

        $forum->update($request->all());

        return response()->json($forum);
    }

    // Eliminar
    public function destroy($id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], Response::HTTP_NOT_FOUND);
        }

        $forum->delete();

        return response()->json(['message' => 'Forum deleted successfully']);
    }
}
