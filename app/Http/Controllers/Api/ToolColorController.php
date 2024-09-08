<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ToolColor;
use Illuminate\Http\Request;

class ToolColorController extends Controller
{
    public function index()
    {
        $ToolColors=ToolColor::all();
        //$ToolColors = ToolColor::included()->get();
        //$ToolColors= ToolColor::included()->filter();
        //$ToolColors=ToolColor::included()->filter()->sort()->get();
        //$ToolColors=ToolColor::included()->filter()->sort()->getOrPaginate();
        return response()->json($ToolColors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'user_id'=> 'required|exists:users,id',
            'ToolColor_id'=> 'required|exists:ToolColors,id',
            'tipo_ToolColor' => 'required|max:255',
            
            
          
        ]);

        $ToolColor = ToolColor::create($request->all());

        return response()->json($ToolColor);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ToolColor  $ToolColor
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $ToolColor= ToolColor::included()->findOrFail($id);
        return response()->json($ToolColor);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ToolColor  $ToolColor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ToolColor $ToolColor)
    {
        $request->validate([
            'user_id'=> 'required|exists:users,id',
            'ToolColor_id'=> 'required|exists:ToolColors,id',
            'tipo_ToolColor' => 'required|max:255',
            
        ]);

        $ToolColor->update($request->all());

        return response()->json($ToolColor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ToolColor  $ToolColor
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToolColor $ToolColor)
    {
        $ToolColor->delete();
        return response()->json($ToolColor);
    }
}
