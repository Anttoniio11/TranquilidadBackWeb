<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\PersonalGoal;
use Illuminate\Http\Request;

class PersonalGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $info = PersonalGoal::all();
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
            'description' => 'required',
            'pesoDeseadoKg' => 'required',
            'comidaHabitual' => 'required',
            'alturaCm' => 'required',
            'tipoMetabolismo' => 'required',
        ]);

        $info = PersonalGoal::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $info = PersonalGoal::included()->findOrFail($id);
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
    public function update(Request $request, PersonalGoal $info)
    {
        $request->validate([
            'pesoKg',
            'pesoDeseadoKg',
            'comidaHabitual',
            'alturaCm',
            'tipoMetabolismo' . $info->id,

        ]);

        $info->update($request->all());

        return response()->json($info);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalGoal $info)
    {
        $info->delete();
        return response()->json();
    }
}
