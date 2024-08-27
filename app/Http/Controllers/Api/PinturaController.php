<?php

namespace App\Http\Controllers\Api;
use App\Models\Pintura;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PinturaController extends Controller
{
    public function index()
    {
        $shapes=Pintura::all();
        //$shapes = Pintura::included()->get();
        //$shapes= Pintura::included()->filter();
        //$shapes=Pintura::included()->filter()->sort()->get();
        //$shapes=Pintura::included()->filter()->sort()->getOrPaginate();
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
            'nombre_Pintura' => 'required|max:255',
            'contenido_pintura' => 'required|max:255',
          
        ]);

        $shape = Pintura::create($request->all());

        return response()->json($shape);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pintura  $shape
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $shape = Pintura::included()->findOrFail($id);
        return response()->json($shape);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pintura  $shape
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pintura $shape)
    {
        $request->validate([
           'nombre_Pintura' => 'required|max:255',
            'contenido_pintura' => 'required|max:255',
        ]);

        $shape->update($request->all());

        return response()->json($shape);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pintura  $shape
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pintura $shape)
    {
        $shape->delete();
        return response()->json($shape);
    }
}
