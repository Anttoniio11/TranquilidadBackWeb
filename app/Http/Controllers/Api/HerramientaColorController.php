<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HerramientaColor;
use Illuminate\Http\Request;

class HerramientaColorController extends Controller
{
    public function index()
    {
        $tools=HerramientaColor::all();
        //$shapes = Forma::included()->get();
        //$shapes= Forma::included()->filter();
        //$shapes=Forma::included()->filter()->sort()->get();
        //$shapes=Forma::included()->filter()->sort()->getOrPaginate();
        return response()->json($tools);
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
            'relleno' => 'required|max:255',
            'color' => 'required|max:255',
          
        ]);

        $tools = HerramientaColor::create($request->all());

        return response()->json($tools);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Forma  $shape
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $tools = HerramientaColor::included()->findOrFail($id);
        return response()->json($tools);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forma  $shape
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HerramientaColor $tools)
    {
        $request->validate([
            'relleno' => 'required|max:255',
            'color' => 'required|max:255',
        ]);

        $tools->update($request->all());

        return response()->json($tools);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Forma  $shape
     * @return \Illuminate\Http\Response
     */
    public function destroy(HerramientaColor $tools)
    {
        $tools->delete();
        return response()->json($tools);
    }
}
