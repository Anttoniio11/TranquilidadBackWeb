<?php

namespace App\Http\Controllers\Api;
use App\Models\Publicacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    public function index()
    {
        $shapes=Publicacion::all();
        //$shapes = Publicacion::included()->get();
        //$shapes= Publicacion::included()->filter();
        //$shapes=Publicacion::included()->filter()->sort()->get();
        //$shapes=Publicacion::included()->filter()->sort()->getOrPaginate();
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
           'nombre_Publicacion' => 'required|max:255',
            'descripcion_publicacion' => 'required|max:255',
            'num_reacciones' => 'required|max:255',
            'num_compartidos' => 'required|max:255',

            
          
        ]);

        $shape = Publicacion::create($request->all());

        return response()->json($shape);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publicacion  $shape
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $shape = Publicacion::included()->findOrFail($id);
        return response()->json($shape);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publicacion  $shape
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publicacion $shape)
    {
        $request->validate([
           'nombre_Publicacion' => 'required|max:255',
            'descripcion_publicacion' => 'required|max:255',
            'num_reacciones' => 'required|max:255',
            'num_compartidos' => 'required|max:255',

        ]);

        $shape->update($request->all());

        return response()->json($shape);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publicacion  $shape
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publicacion $shape)
    {
        $shape->delete();
        return response()->json($shape);
    }
}
