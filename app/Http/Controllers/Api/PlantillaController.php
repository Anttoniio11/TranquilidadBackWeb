<?php

namespace App\Http\Controllers\Api;
use App\Models\Plantilla;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlantillaController extends Controller
{
    public function index()
    {
        $shapes=Plantilla::all();
        //$shapes = Plantilla::included()->get();
        //$shapes= Plantilla::included()->filter();
        //$shapes=Plantilla::included()->filter()->sort()->get();
        //$shapes=Plantilla::included()->filter()->sort()->getOrPaginate();
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
            'nombre_Plantilla' => 'required|max:255',
            'contenido_plantilla' => 'required|max:255',
          
        ]);

        $shape = Plantilla::create($request->all());

        return response()->json($shape);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plantilla  $shape
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $shape = Plantilla::included()->findOrFail($id);
        return response()->json($shape);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plantilla  $shape
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plantilla $shape)
    {
        $request->validate([
           'nombre_Plantilla' => 'required|max:255',
            'contenido_plantilla' => 'required|max:255',
            
        ]);

        $shape->update($request->all());

        return response()->json($shape);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plantilla  $shape
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plantilla $shape)
    {
        $shape->delete();
        return response()->json($shape);
    }
}
