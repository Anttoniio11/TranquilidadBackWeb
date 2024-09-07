<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $info = Forum::all();
        return response()->json($info);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'resourceType' => 'required',
            'content' => 'required',
            'publicationDate' => 'required'
        ]);

        $info = Forum::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $info = Forum::included()->findOrFail($id);
        return response()->json($info);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Forum $info)
    {
        $request->validate([
            'resourceType',
            'content',
            'publicationDate'. $info->id,

        ]);

        $info->update($request->all());

        return response()->json($info);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Forum $info)
    {
        $info->delete();
        return response()->json();
    }
}
