<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BinauralSound;
use Illuminate\Http\Request;

class BinauralSoundController extends Controller
{
    
    public function index()
    {
        $binauralSound= BinauralSound::included()
                                ->filter()
                                ->sort()
                                ->getOrPage();
        return response()->json($binauralSound);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|unique:binaural_sounds',
            'frequency'=> 'required|string',
            'description'  => 'nullable|string'

        ]);

        $binauralSound = BinauralSound::create($request->all());
        return response()->json($binauralSound, 201);
    }

   
    public function show($id)
    {
        $binauralSound= BinauralSound::incluid()->findOrFail($id);
        return $binauralSound;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BinauralSound $binauralSound)
    {
        $request->validate([
            'name'=> 'required|string|unique:binaural_sounds',
            'frequency'=> 'required|string',
            'description'  => 'nullable|string'

        ]);
        $binauralSound->update($request->all());
        return response()->json($binauralSound);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BinauralSound $binauralSound)
    {
        $binauralSound->delete();
        return response()->json($binauralSound);
    }
}
