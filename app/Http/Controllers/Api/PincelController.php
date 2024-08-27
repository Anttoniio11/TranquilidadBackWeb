<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pincel;
class PincelController extends Controller
{
    public function index()
    {
        $brushes=Pincel::all();
        //$brushes = Pincel::included()->get();
        //$brushes= Pincel::included()->filter();
        //$brushes=Pincel::included()->filter()->sort()->get();
        //$brushes=Pincel::included()->filter()->sort()->getOrPaginate();
        return response()->json($brushes);
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

        $brush = Pincel::create($request->all());

        return response()->json($brush);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pincel  $brush
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $brush= Pincel::included()->findOrFail($id);
        return response()->json($brush);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pincel  $brush
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pincel $brush)
    {
        $request->validate([
           'nombre_pincel' => 'required|max:255',
            'textura' => 'required|max:255',
            'estilo_trazo' => 'required|max:255',
        ]);

        $brush->update($request->all());

        return response()->json($brush);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pincel  $brush
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pincel $brush)
    {
        $brush->delete();
        return response()->json($brush);
    }
}
