<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pincel;
class PincelController extends Controller
{
    public function index()
    {
        $shapes=Pincel::all();
        //$shapes = Pincel::included()->get();
        //$shapes= Pincel::included()->filter();
        //$shapes=Pincel::included()->filter()->sort()->get();
        //$shapes=Pincel::included()->filter()->sort()->getOrPaginate();
        return response()->json($shapes);
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
            'nombre_pincel' => 'required|max:255',
            'textura' => 'required|max:255',
            'estilo_trazo' => 'required|max:255',
            
          
        ]);

        $shape = Pincel::create($request->all());

        return response()->json($shape);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pincel  $shape
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $shape = Pincel::included()->findOrFail($id);
        return response()->json($shape);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pincel  $shape
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pincel $shape)
    {
        $request->validate([
           'nombre_pincel' => 'required|max:255',
            'textura' => 'required|max:255',
            'estilo_trazo' => 'required|max:255',
        ]);

        $shape->update($request->all());

        return response()->json($shape);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pincel  $shape
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pincel $shape)
    {
        $shape->delete();
        return response()->json($shape);
    }
}
