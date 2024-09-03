<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\HealthPlan;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class HealthPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $info = HealthPlan::all();
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
            'pesoKg' => 'required',
            'pesoDeseadoKg' => 'required',
            'comidaHabitual' => 'required',
            'alturaCm' => 'required',
            'tipoMetabolismo' => 'required',
        ]);

        $info = HealthPlan::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $info = HealthPlan::included()->findOrFail($id);
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
    public function update(Request $request, HealthPlan $info)
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
    public function destroy(string $id)
    {
        //
    }
}
